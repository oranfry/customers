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
            'icon' => function($records) : string {
                return 'docpdf';
            },
            'date' => function($records) {
                return $records['/']->date;
            },
            'email' => function($records) {
                return @$records['/']->email;
            },
            'name' => function($records) {
                return $records['/']->name;
            },
            'address' => function($records) {
                return $records['/']->address;
            },
            'description' => function($records) {
                return $records['/']->description;
            },
            'amount' => function($records) : float {
                return $records['/']->amount;
            },
            // 'file' => function($records) {
            //     'type' => 'file',
            //     'icon' => 'docpdf',
            //     'path' => 'customerinvoice',
            //     'supress_header' => true,
            //     'generable' => true,
            // },
            'broken' => function($records) {
                if (!@$records['/']->user) {
                    return 'no user';
                }

                // $fy = date('Y') + (date('m') > 3 ? 1 : 0);
                // $afterdate = ($fy - 8) . '-04-01';

                // if (strcmp($line->date, $afterdate) >= 0 && !@$records['/']->file_path) {
                //     return 'missing file';
                // }
            },
        ];
        $this->unfuse_fields = [
            'date' => function($line, $oldline) {
                return $line->date;
            },
            'name' => function($line, $oldline) {
                return $line->name;
            },
            'email' => function($line, $oldline) {
                return @$line->email;
            },
            'address' => function($line, $oldline) {
                return $line->address;
            },
            'amount' => function($line, $oldline) {
                return @$line->amount;
            },
            'description' => function($line, $oldline) {
                return @$line->description;
            },
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
