<?php
namespace customers\linetype;

class ncustomerinvoice extends customerinvoice
{
    public function __construct()
    {
        parent::__construct();

        list($amount) = filter_objects($this->fields, 'name', 'is', 'amount');
        $amount->fuse = '-{t}.amount';
    }
}
