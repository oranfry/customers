<?php
namespace customers\linetype;

class customerinvoice extends \Linetype
{
    public function __construct()
    {
        $this->label = 'Customer Invoice';
        $this->icon = 'docpdf';
        $this->table = 'customerinvoice';
        $this->fields = [
            (object) [
                'name' => 'icon',
                'type' => 'icon',
                'fuse' => "'docpdf'",
                'derived' => true,
            ],
            (object) [
                'name' => 'date',
                'type' => 'date',
                'groupable' => true,
                'fuse' => '{t}.date',
            ],
            (object) [
                'name' => 'email',
                'type' => 'text',
                'fuse' => '{t}.email',
            ],
            (object) [
                'name' => 'name',
                'type' => 'text',
                'fuse' => '{t}.name',
            ],
            (object) [
                'name' => 'address',
                'type' => 'multiline',
                'fuse' => '{t}.address',
            ],
            (object) [
                'name' => 'description',
                'type' => 'text',
                'fuse' => '{t}.description',
            ],
            (object) [
                'name' => 'amount',
                'type' => 'number',
                'dp' => 2,
                'summary' => 'sum',
                'fuse' => '{t}.amount',
            ],
            (object) [
                'name' => 'file',
                'type' => 'file',
                'icon' => 'docpdf',
                'path' => 'customerinvoice',
                'supress_header' => true,
                'generable' => true,
            ],
            (object) [
                'name' => 'broken',
                'type' => 'text',
                'fuse' => "if({t}.user is null or {t}.user = '', 'no user', '')",
                'derived' => true,
                'calc' => function($line) {
                    if (@$line->broken) {
                        return $line->broken;
                    }

                    $fy = date('Y') + (date('m') > 3 ? 1 : 0);
                    $afterdate = ($fy - 8) . '-04-01';

                    if (strcmp($line->date, $afterdate) >= 0 && !@$line->file_path) {
                        return 'missing file';
                    }
                },
            ],
        ];
        $this->unfuse_fields = [
            '{t}.date' => (object) [
                'expression' => ':{t}_date',
                'type' => 'date',
            ],
            '{t}.name' => (object) [
                'expression' => ':{t}_name',
                'type' => 'varchar(255)',
            ],
            '{t}.email' => (object) [
                'expression' => ':{t}_email',
                'type' => 'varchar(255)',
            ],
            '{t}.address' => (object) [
                'expression' => ':{t}_address',
                'type' => 'varchar(255)',
            ],
            '{t}.amount' => (object) [
                'expression' => ':{t}_amount',
                'type' => 'decimal(18, 2)',
            ],
            '{t}.description' => (object) [
                'expression' => ':{t}_description',
                'type' => 'varchar(255)',
            ],
        ];
        $this->children = [
            (object) [
                'label' => 'lines',
                'linetype' => 'customerinvoiceline',
                'rel' => 'many',
                'parent_link' => 'customerinvoicecustomerinvoiceline',
           ],
        ];
    }

    public function validate($line)
    {
        $errors = [];

        if ($line->date == null) {
            $errors[] = 'no date';
        }

        if ($line->name == null) {
            $errors[] = 'no name';
        }

        if ($line->address == null) {
            $errors[] = 'no address';
        }

        return $errors;
    }

    public function complete($line)
    {
        if (!@$line->amount) {
            $line->amount = $this->calculate_total($line);
        }
    }

    private function calculate_total($line)
    {
        $subtotal = '0.00';

        list($descriptor) = filter_objects($this->children, 'label', 'is', 'lines');

        foreach ($this->load_childset($line, $descriptor) as $childline) {
            $subtotal = bcadd($subtotal, $childline->amount, 2);
        }

        return bcmul(bcadd('0.005', $subtotal, 3), '1.15', 2);
    }
}
