<?php

class Points
{
    protected $algo = [];
    protected $CI;

    public function __construct($params)
    {
        $this->algo = $params['algo'];
    }

    public function getPoints(array $inputData)
    {
        $points = 0;

        foreach ($this->algo as $metric => $metricCalc) {
            if (array_key_exists($metric, $inputData)) {
                $points += $metricCalc['weight'] * $metricCalc['points'] * (
                    ($metricCalc['report'] == 'inverse') 
                        ? round((empty($inputData[$metric]) ? 0 : 100 / $inputData[$metric])) 
                        : $inputData[$metric]
                );
            }
        }

        return $points;
    }
}