<?php
declare(strict_types=1);

namespace App\Services;


class EmployeeService
{
    /**
     * @param array $employees
     * @return array
     */
    public function avgMatch(array $employees): array
    {
        $count = count($employees);
        $matchScores = [];

        for ($i = 0; $i < $count; ++$i) {
            if (isset($employees[$i]) && $employees[$i]['Matched']) {
                continue;
            }

            $max = $this->getMax($employees, $i, $count);
            $matchScores[] = $max;

            if (isset($max['i']) && isset($max['j'])) {
                $employees[$max['i']]['Matched'] = true;
                $employees[$max['j']]['Matched'] = true;
            }
        }
//        dd($matchScores);
        $sum = 0;
        foreach ($matchScores as $key) {
            $sum += $key['score'];
        }

        return ['score' => $sum / count(array_filter($matchScores)), 'matchScores' => $matchScores, 'employeesCount' => $count];
    }

    /**
     * @param array $employees
     * @param int $I
     * @param int $count
     * @return array|int[]
     */
    private function getMax(array $employees, int $I, int $count): array
    {
        $max = ['score' => 0];

        for ($i = $I; $i < $I + 1; ++$i) {
            for ($j = $i + 1; $j < $count; ++$j) {
                if ($employees[$j]['Matched']) {
                    continue;
                }
                $matchScore = $this->getMatch($employees[$i], $employees[$j], $I, $j);
                if ($matchScore['score'] >= $max['score']) {
                    $max = $matchScore;
                }
                if ($matchScore['score'] == 0 && $max['score'] == 0) {
                    $max = $matchScore;
                }
            }
        }

        return $max;
    }

    /**
     * @param array $employee1
     * @param array $employee2
     * @param int $i
     * @param int $j
     * @return array
     */
    public function getMatch(array $employee1, array $employee2, int $i, int $j): array
    {
        $score = 0;

        if ($employee1['Division'] === $employee2['Division']) {
            $score += 30;
        }
        if (abs($employee1['Age'] - $employee2['Age']) <= 5) {
            $score += 30;
        }
        if ($employee1['Timezone'] === $employee2['Timezone']) {
            $score += 40;
        }

        return ['score' => $score, 'employee1' => $employee1['Name'], 'employee2' => $employee2['Name'], 'i' => $i, 'j' => $j];
    }
}
