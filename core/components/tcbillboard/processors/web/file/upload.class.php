<?php

class tcBillboardTicketFileUploadProcessor extends TicketFileUploadProcessor
{
    public $classKey = 'TicketFile';
    public $languageTopics = array('tickets:default');
    public $permission = 'ticket_file_upload';
    /** @var modMediaSource $mediaSource */
    public $mediaSource;
    /** @var Ticket $ticket */
    private $ticket = 0;
    private $class = 'Ticket';


    /**
     * @return array|mixed|string
     */
    public function process()
    {
        if (!$data = $this->handleFile()) {
            return $this->failure($this->modx->lexicon('ticket_err_file_ns'));
        }

        $properties = $this->mediaSource->getPropertyList();
        $tmp = explode('.', $data['name']);
        $extension = strtolower(end($tmp));

        $image_extensions = $allowed_extensions = array();
        if (!empty($properties['imageExtensions'])) {
            $image_extensions = array_map('trim', explode(',', strtolower($properties['imageExtensions'])));
        }
        if (!empty($properties['allowedFileTypes'])) {
            $allowed_extensions = array_map('trim', explode(',', strtolower($properties['allowedFileTypes'])));
        }
        if (!empty($allowed_extensions) && !in_array($extension, $allowed_extensions)) {
            @unlink($data['tmp_name']);
            return $this->failure($this->modx->lexicon('ticket_err_file_ext'));
        } elseif (in_array($extension, $image_extensions)) {
            $type = 'image';
        } else {
            $type = $extension;
        }

        $path = '0/';
        $filename = !empty($properties['imageNameType']) && $properties['imageNameType'] == 'friendly'
            ? $this->ticket->cleanAlias($data['name'])
            : $data['hash'] . '.' . $extension;
        if (strpos($filename, '.' . $extension) === false) {
            $filename .= '.' . $extension;
        }
        // Check for existing file
        $where = $this->modx->newQuery($this->classKey, array('class' => $this->class));
        if (!empty($this->ticket->id)) {
            $where->andCondition(array('parent:IN' => array(0, $this->ticket->id)));
        } else {
            $where->andCondition(array('parent' => 0));
        }
        $where->andCondition(array('file' => $filename, 'OR:hash:=' => $data['hash']), null, 1);
        if ($this->modx->getCount($this->classKey, $where)) {
            @unlink($data['tmp_name']);

            return $this->failure($this->modx->lexicon('ticket_err_file_exists', array('file' => $data['name'])));
        }

        // Check for files limit
        if ($filesLimit = $this->modx->getOption('tcbillboard_files_limit', null, 12)) {
            $this->modx->lexicon->load('tcbillboard:default');
            $where = $this->modx->newQuery($this->classKey, array('class' => $this->class));
            if (!empty($this->ticket->id)) {
                $where->andCondition(array('parent:IN' => array(0, $this->ticket->id)));
            } else {
                $where->andCondition(array('parent' => 0));
            }
            $where->andCondition(array('createdby' => $this->modx->user->id));
            if ($this->modx->getCount($this->classKey, $where) >= $filesLimit) {
                @unlink($data['tmp_name']);

                return $this->failure('Вы не можете загрузить больше '.$filesLimit.' файлов');
            }
        }

        /** @var TicketFile $uploaded_file */
        $uploaded_file = $this->modx->newObject('TicketFile', array(
            'parent' => 0,
            'name' => $data['name'],
            'file' => $filename,
            'path' => $path,
            'source' => $this->mediaSource->get('id'),
            'type' => $type,
            'createdon' => date('Y-m-d H:i:s'),
            'createdby' => $this->modx->user->id,
            'deleted' => 0,
            'hash' => $data['hash'],
            'size' => $data['size'],
            'class' => $this->class,
            'properties' => $data['properties'],
        ));

        $this->mediaSource->createContainer($uploaded_file->get('path'), '/');
        $this->mediaSource->errors = array();
        if ($this->mediaSource instanceof modFileMediaSource) {
            $upload = $this->mediaSource->createObject($uploaded_file->get('path'), $uploaded_file->get('file'), '');
            if ($upload) {
                copy($data['tmp_name'], urldecode($upload));
            }
        } else {
            $data['name'] = $filename;
            $upload = $this->mediaSource->uploadObjectsToContainer($uploaded_file->get('path'), array($data));
        }
        @unlink($data['tmp_name']);

        if ($upload) {
            $url = $this->mediaSource->getObjectUrl($uploaded_file->get('path') . $uploaded_file->get('file'));
            $uploaded_file->set('url', $url);
            $uploaded_file->save();
            $uploaded_file->generateThumbnails($this->mediaSource);

            return $this->success('', $uploaded_file);
        } else {
            $this->modx->log(modX::LOG_LEVEL_ERROR,
                '[Tickets] Could not save file: ' . print_r($this->mediaSource->getErrors(), 1));

            return $this->failure($this->modx->lexicon('ticket_err_file_save'));
        }
    }
}

return 'tcBillboardTicketFileUploadProcessor';