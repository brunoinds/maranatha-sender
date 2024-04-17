<?php

namespace App\Support\Generators\Records\Attendances;

use App\Helpers\Enums\MoneyType;
use App\Support\Exchange\Exchanger;

use App\Helpers\Toolbox;

use App\Support\Assistants\WorkersAssistant;
use DateTime;
use App\Models\Job;
use App\Models\Expense;



class RecordAttendancesByJobsExpenses
{

    private DateTime $startDate;
    private DateTime $endDate;
    private string|null $jobCode = null;
    private string|null $expenseCode = null;
    private string|null $supervisor = null;
    private string|null $workerDni = null;

    /**
     * @param array $options
     * @param DateTime $options['startDate']
     * @param DateTime $options['endDate']
     * @param null|string $options['jobCode']
     * @param null|string $options['expenseCode']
     * @param null|string $options['supervisor']
     * @param null|string $options['workerDni']
     */

    public function __construct(array $options){
        $this->startDate = $options['startDate'];
        $this->endDate = $options['endDate'];
        $this->jobCode = $options['jobCode'];
        $this->expenseCode = $options['expenseCode'];
        $this->supervisor = $options['supervisor'];
        $this->workerDni = $options['workerDni'];
    }

    private function getWorkersData():array
    {
        $workersSpendings = collect(WorkersAssistant::getWorkersSpendings())->map(function($workerSpendings){
            return $workerSpendings['spendings'];
        })->flatten(1);

        $spendingsInSpan = $workersSpendings->where('date', '>=', $this->startDate->format('c'))->where('date', '<=', $this->endDate->format('c'));

        if ($this->workerDni !== null){
            $spendingsInSpan = $spendingsInSpan->where('worker.dni', '=', $this->workerDni);
        }

        if ($this->jobCode !== null){
            $spendingsInSpan = $spendingsInSpan->where('job.code', '=', $this->jobCode);
        }

        if ($this->expenseCode !== null){
            $spendingsInSpan = $spendingsInSpan->where('expense.code', '=', $this->expenseCode);
        }

        if ($this->supervisor !== null){
            $spendingsInSpan = $spendingsInSpan->where('worker.supervisor', '=', $this->supervisor);
        }

        $spendingsInSpan = collect($spendingsInSpan)->groupBy(function($spending){
            return $spending['job']['code'] . '/~/' . $spending['expense']['code'];
        })->sortKeys();


        $jobs = Job::all();
        $expenses = Expense::all();

        $attendancesByJobExpense = collect($spendingsInSpan)->map(function($spendings, $identificator) use ($jobs, $expenses) {
            $jobCode = explode('/~/', $identificator)[0];
            $expenseCode = explode('/~/', $identificator)[1];

            return [
                'job' => $jobCode . ' - ' . $jobs->where('code', $jobCode)->first()->name,
                'expense' => $expenseCode . ' - ' . $expenses->where('code', $expenseCode)->first()->name,
                'spendings' => collect($spendings)->map(function($spending){
                    $spending = Toolbox::toObject($spending);
                    $spending->amountInSoles = (function() use ($spending){
                        return $spending->amount;
                    })();
                    $spending->amountInDollars = (function() use ($spending){
                        $date = new DateTime($spending->date);
                        return Exchanger::on($date)->convert($spending->amount,MoneyType::PEN, MoneyType::USD);
                    })();

                    return $spending;
                })
            ];
        })->toArray();


        $attendancesByJobExpense = collect($attendancesByJobExpense)->map(function($item){
            $spendings = $item['spendings'];

            $item['totals'] = [
                'amount_in_soles' => 0,
                'amount_in_dollars' => 0
            ];


            $item['totals']['amount_in_soles'] = $spendings->sum(function($spending){
                return $spending->amountInSoles;
            });
            $item['totals']['amount_in_dollars'] = $spendings->sum(function($spending){
                return $spending->amountInDollars;
            });

            return [
                'job' => $item['job'],
                'expense' => $item['expense'],
                'amount_in_soles' => $item['totals']['amount_in_soles'],
                'amount_in_dollars' => $item['totals']['amount_in_dollars'],
            ];
        });

        $attendancesByJobExpense = $attendancesByJobExpense->values();
        return $attendancesByJobExpense->toArray();
    }

    private function createTable():array{
        $spendings = $this->getWorkersData();

        $spendings = array_column($spendings, null);


        $mergingJobCodeRows = (function() use ($spendings){
            $indexes = [];
            $currentJobCode = null;
            $currentIndex = null;
            foreach($spendings as $index => $spending){
                if ($currentJobCode === null){
                    $currentJobCode = $spending['job'];
                    $currentIndex = $index;
                } else {
                    if ($currentJobCode === $spending['job']){
                        continue;
                    } else {
                        if ($currentIndex !== $index - 1){
                            $indexes[] = ['from' => $currentIndex, 'to' => $index - 1];
                        }
                        $currentJobCode = $spending['job'];
                        $currentIndex = $index;
                    }
                }
            }
            return $indexes;
        })();

        return [
            'headers' => [
                [
                    'title' => 'Job',
                    'key' => 'job',
                ],
                [
                    'title' => 'Expense',
                    'key' => 'expense',
                ],
                [
                    'title' => 'Costo Total (Dólares)',
                    'key' => 'amount_in_dollars',
                ],
                [
                    'title' => 'Costo Total (Soles)',
                    'key' => 'amount_in_soles',
                ]
            ],
            'body' => $spendings,
            'footer' => [
                'totals' => [
                    'title' => 'Totales',
                    'items' => [
                        [
                            'key' => 'amount_in_soles',
                            'value' => round(array_sum(array_column($spendings, 'amount_in_soles')), 2),
                        ],
                        [
                            'key' => 'amount_in_dollars',
                            'value' => round(array_sum(array_column($spendings, 'amount_in_dollars')),2),
                        ]
                    ]
                ]
            ],
            'rules' => [
                'merging' => [
                    'rows' => [
                        [
                            'key' => 'job',
                            'indexes' => $mergingJobCodeRows
                        ]
                    ]
                ]
            ]
        ];
    }


    public function generate():array{
        return [
            'data' => $this->createTable(),
            'query' => [
                'startDate' => $this->startDate->format('c'),
                'endDate' => $this->endDate->format('c'),
                'supervisor' => $this->supervisor,
                'jobCode' => $this->jobCode,
                'expenseCode' => $this->expenseCode,
                'workerDni' => $this->workerDni,
            ],
        ];
    }
}