<?php
namespace tablelink;

class customerinvoicecustomerinvoiceline extends \Tablelink
{
    public function __construct()
    {
        $this->tables = ['customerinvoice', 'customerinvoiceline'];
        $this->middle_table = 'tablelink_customerinvoice_customerinvoiceline';
        $this->ids = ['invoice', 'line'];
        $this->type = 'onemany';
    }
}
