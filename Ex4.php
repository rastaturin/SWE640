<?php

$list = [
    'AFT',
    'ALE',
    'EEL',
    'HEEL',
    "HIKE",
    "HOSES",
    "KEEL",
    "KNOT",
    "LASER",
    "LEE",
    "LINE",
    "SAILS",
    "SHEET",
    "STEER",
    "TIR"
];

$n = 5;
$m = 6;

$empty = [
    [1,2], [2,2], [4,2], [1,3], [2,4], [2,6], [3,6], [5,6]
];

$numbers = [
    [1,1], [3,1], [5,1], [2,3], [4,3], [1,4], [3,4], [1,5]
];

$board = new Board($n, $m, $empty);
$board->solve($list, $numbers);


class Board
{
    public $board;
    public $n, $m;

    /**
     * @param $n
     * @param $m
     * @param $empty
     */
    public function __construct($n, $m, $empty)
    {
        $this->n = $n;
        $this->m = $m;
        for ($i = 1; $i <= $n; $i++) {
            $this->board[$i] = [];
            for ($j = 1; $j <= $m; $j++) {
                if (in_array([$i, $j], $empty)) {
                    $this->board[$i][$j] = "#";
                } else {
                    $this->board[$i][$j] = ".";
                }
            }
        }
    }

    /**
     * @param array $list
     * @param $numbers
     */
    public function solve($list, $numbers)
    {
        $this->step($this->board, $list, $numbers, []);
    }

    /**
     * @param $board
     * @param $words
     */
    private function show($board, $words)
    {
        foreach ($words as $i => $word) {
            echo $i + 1 . ". $word" . PHP_EOL;
        }

        for ($j = 1; $j <= $this->m; $j++) {
            for ($i = 1; $i <= $this->n; $i++) {
                echo $board[$i][$j];
            }
            echo PHP_EOL;
        }
    }

    /**
     * @param $board
     * @param $list
     * @param $numbers
     * @param $result
     */
    private function step($board, $list, $numbers, $result)
    {
        if (empty($numbers)) {
            $this->show($board, $result);
            return;
        }

        $pos = array_pop($numbers);
        foreach ($list as $i => $word) {
            foreach ([0, 1] as $dir) {
                if ($board2 = $this->canStart($board, $word, $pos, $dir)) {
                    $list2 = $list;
                    unset($list2[$i]);
                    $this->step($board2, array_values($list2), $numbers, array_merge([$list[$i]], $result));
                }
            }
        }
    }

    /**
     * @param array $board
     * @param string $word
     * @param int $pos
     * @param int $dir
     * @return bool|array
     */
    private function canStart($board, $word, $pos, $dir)
    {
        for ($i = 0; $i < strlen($word); $i++) {
            $x = $pos[0] + $dir * $i;
            $y = $pos[1] + (1 - $dir) * $i;
            if ($x > $this->n || $y > $this->m) {
                return false;
            }
            if ($board[$x][$y] == '.' || $board[$x][$y] == $word[$i]) {
                $board[$x][$y] = $word[$i];
            } else {
                return false;
            }
        }
        return $board;
    }
}
