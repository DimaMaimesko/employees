<?php

use Illuminate\Database\Seeder;
use App\Models\Employee;

class EmployeesTableSeeder extends Seeder
{

    public function run()
    {
        $depth_0_sort = 10;
        $depth_1_sort = random_int(5, 10);
        $depth_2_sort = random_int(5, 15);
        $depth_3_sort = random_int(5, 15);
        $depth_4_sort = random_int(5, 15);

        for ($i = 0; $i <= $depth_0_sort; $i++){
            factory(Employee::class)->create([
                'sort' => $i,
                'salary' => strval(random_int(100000, 1000000)),
                'boss_id' => null
            ]);
        };

        $startId = 0;
        $lastId = Employee::max('id');
        $depth_0_employees = Employee::whereBetween('id', [$startId, $lastId])->get();
        foreach ($depth_0_employees as $employee){
            for ($i = 0; $i <= $depth_1_sort; $i++){
                factory(Employee::class)->create([
                    'sort' => $i,
                    'salary' => strval(random_int(10000, 100000)),
                    'boss_id' => $employee->id
                ]);
            };
        };

        $startId = $lastId;
        $lastId = Employee::max('id');
        $depth_1_employees = Employee::whereBetween('id', [$startId, $lastId])->get();
        foreach ($depth_1_employees as $employee){
            for ($i = 0; $i <= $depth_2_sort; $i++){
                factory(Employee::class)->create([
                    'sort' => $i,
                    'salary' => strval(random_int(1000, 10000)),
                    'boss_id' => $employee->id
                ]);
            };
        };

        $startId = $lastId;
        $lastId = Employee::max('id');
        $depth_2_employees = Employee::whereBetween('id', [$startId, $lastId])->get();
        foreach ($depth_2_employees as $employee){
            for ($i = 0; $i <= $depth_3_sort; $i++){
                factory(Employee::class)->create([
                    'sort' => $i,
                    'salary' => strval(random_int(100, 1000)),
                    'boss_id' => $employee->id
                ]);
            };
        };

        $startId = $lastId;
        $lastId = Employee::max('id');
        $depth_3_employees = Employee::whereBetween('id', [$startId, $lastId])->get();
        foreach ($depth_3_employees as $employee){
            for ($i = 0; $i <= $depth_4_sort; $i++){
                factory(Employee::class)->create([
                    'sort' => $i,
                    'salary' => strval(random_int(10, 100)),
                    'boss_id' => $employee->id
                ]);
            };
        };

    }
}