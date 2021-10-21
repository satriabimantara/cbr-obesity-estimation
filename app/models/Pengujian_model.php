<?php
class Pengujian_model
{
    public function findAccuracy($cases, $compare_column_1, $compare_column_2)
    {
        $sum_case = 0;
        $n_case = count($cases);
        foreach ($cases as $index_case  => $case) {
            if ($case[$compare_column_1] == $case[$compare_column_2]) {
                $sum_case++;
            }
        }
        return ($sum_case / $n_case) * 100;
    }
}
