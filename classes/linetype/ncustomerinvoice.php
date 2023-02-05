<?php
namespace customers\linetype;

class ncustomerinvoice extends customerinvoice
{
    public function __construct()
    {
        parent::__construct();

        $this->fields['amount'] = fn($records) : float => 0 - $records['/']->amount;
        $this->unfuse_fields['amount'] = fn ($line, $oldline) => @$line->amount ? 0 - $line->amount : null;
    }
}
