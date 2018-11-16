<?php

use Illuminate\Database\Seeder;
use App\Models\Employee;

class EmployeesTableSeeder extends Seeder
{

    public function run()
    {
        $depth_0_sort = 10;
        $depth_1_sort = random_int(1, 5);
        $depth_2_sort = random_int(1, 3);
        $depth_3_sort = random_int(1, 3);
        $depth_4_sort = random_int(1, 3);

        for ($i = 0; $i <= $depth_0_sort; $i++){
            factory(Employee::class)->create([
                'depth' => 0,
                'sort' => $i,
                'salary' => strval(random_int(100000, 1000000)),
                'boss_id' => null
            ]);
        };

        $depth_0_employees = Employee::where('depth', 0)->get();
        foreach ($depth_0_employees as $employee){
            for ($i = 0; $i <= $depth_1_sort; $i++){
                factory(Employee::class)->create([
                    'depth' => 1,
                    'sort' => $i,
                    'salary' => strval(random_int(10000, 100000)),
                    'boss_id' => $employee->id
                ]);
            };
        };

        $depth_1_employees = Employee::where('depth', 1)->get();
        foreach ($depth_1_employees as $employee){
            for ($i = 0; $i <= $depth_2_sort; $i++){
                factory(Employee::class)->create([
                    'depth' => 2,
                    'sort' => $i,
                    'salary' => strval(random_int(1000, 10000)),
                    'boss_id' => $employee->id
                ]);
            };
        };

        $depth_2_employees = Employee::where('depth', 2)->get();
        foreach ($depth_2_employees as $employee){
            for ($i = 0; $i <= $depth_3_sort; $i++){
                factory(Employee::class)->create([
                    'depth' => 3,
                    'sort' => $i,
                    'salary' => strval(random_int(100, 1000)),
                    'boss_id' => $employee->id
                ]);
            };
        };

        $depth_3_employees = Employee::where('depth', 3)->get();
        foreach ($depth_3_employees as $employee){
            for ($i = 0; $i <= $depth_4_sort; $i++){
                factory(Employee::class)->create([
                    'depth' => 4,
                    'sort' => $i,
                    'salary' => strval(random_int(10, 100)),
                    'boss_id' => $employee->id
                ]);
            };
        };

    }
}