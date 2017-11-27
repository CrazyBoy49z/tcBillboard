<?php

class tcBillboardTickets extends Tickets
{
    protected $classKey = 'TicketFile';
    protected $class = 'Ticket';


    public function fileUpload($data, $class = 'Ticket')
    {
        $filesLimit = $this->modx->getOption('tcbillboard_files_limit', null, 12);

        $where = $this->modx->newQuery($this->classKey, array('class' => $this->class));
        if (!empty($data['tid'])) {
            $where->andCondition(array('parent:IN' => array(0, $data['tid'])));
        } else {
            $where->andCondition(array('parent' => 0));
        }
        $where->andCondition(array('createdby' => $this->modx->user->id));
        if ($this->modx->getCount($this->classKey, $where) >= $filesLimit) {
            @unlink($data['tmp_name']);

            return $this->error($this->modx->lexicon('tcbillboard_err_file_upload',
                array('namespace' => 'tcbillboard')) . $filesLimit);
        }
        return parent::fileUpload($data, $class = 'Ticket');
    }
}