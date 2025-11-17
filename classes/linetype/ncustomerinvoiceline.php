<?php

namespace customers\linetype;

use simplefields\traits\SimpleFields;

class ncustomerinvoiceline extends customerinvoiceline
{
    use SimpleFields;

    public function __construct()
    {
        parent::__construct();

        $old_fuse = $this->fields['amount'];
        $old_unfuse = $this->unfuse_fields['amount'];

        $this->fields['amount'] = fn ($records) : string => bcsub('0', bcadd(bcmul($old_fuse($records), '1.15', 3), '0.005', 3), 2);
        $this->unfuse_fields['amount'] = fn ($line, $oldline) : string => bcsub('0', bcadd(bcdiv($old_unfuse($line, $oldline), '1.15', 3), '0.005', 3), 2);
    }
}
