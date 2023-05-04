<?php

namespace customers\linetype;

class ncustomerinvoice extends customerinvoice
{
    public function __construct()
    {
        parent::__construct();

        $old_fuse = $this->fields['amount'];
        $old_unfuse = $this->unfuse_fields['amount'];

        $this->fields['amount'] = fn ($records) : string => bcsub('0', $old_fuse($records), 2);
        $this->unfuse_fields['amount'] = fn ($line, $oldline) : string => bcsub('0', $old_unfuse($line, $oldline), 2);
    }
}
