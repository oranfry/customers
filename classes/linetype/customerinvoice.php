<?php
namespace customers\linetype;

class customerinvoice extends \jars\Linetype
{
    public function __construct()
    {
        $this->table = 'customerinvoice';

        $this->fields = [
            'icon' => fn($records) : string => 'docpdf',
            'date' => fn($records) => $records['/']->date,
            'email' => fn($records) => @$records['/']->email,
            'name' => fn($records) => $records['/']->name,
            'address' => fn($records) => $records['/']->address,
            'description' => fn($records) => $records['/']->description,
            'amount' => fn($records) : float => $records['/']->amount,
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
            'date' => fn($line, $oldline) => $line->date,
            'name' => fn($line, $oldline) => $line->name,
            'email' => fn($line, $oldline) => @$line->email,
            'address' => fn($line, $oldline) => $line->address,
            'amount' => fn($line, $oldline) => @$line->amount,
            'description' => fn($line, $oldline) => @$line->description,
        ];

        $this->children = [
            (object) [
                'linetype' => 'customerinvoiceline',
                'property' => 'lines',
                'tablelink' => 'customerinvoice_line',
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

    public function complete($line) : void
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
