<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\Plan_c_bonus;
use App\Plan_c_wd;

class Plan_c_board extends Model 
{
    /*  define tablename */
    protected $table = 'tb_plan_c_board';

    protected $fillable = array('id', 'plan_c_id', 'parent_id', 'no_urut', 'fly_at');

    private $maxUrut = 13;

    /*
    **  getLastBoard => mendapatkan board terakhir, digunakan untuk awal pembentukan board atau flying board
    */
    private function getLastBoard() {
        return $this->orderBy('id', 'desc')->lockForUpdate()->first();
    }

    private function getSummaryByIdBuilder() {
        return DB::table('tb_plan_c_board') 
                            ->selectRaw("id, count(no_urut) as jumlah")
                            ->groupBy('id');
    }

    /*
    **  getBoardById => mendapatkan board berdasarkan id
    **  @boardId => integer, id board
    **  return array rows object
    */
    public function getBoardById($boardId)
    {
        return $this->where('id', '=', $boardId)->orderBy('no_urut')->lockForUpdate()->get();
    }

    public function getDataBoardByUrut($boardId, $noUrut)
    {
        return $this->where('id', '=', $boardId)->where('no_urut', '=', $noUrut)->lockForUpdate()->first();
    }

    /*
    **  getNewBoardC => digunakan untuk mendapatkan board mana yg siap diisi member plan C yg baru.
                        disini hanya dapat mengatur no_urut saja, sehingga nantinya hanya cukup mengisi plan_c_id saja
    **  return object yg akan digunakan sebagai parameter untuk register plan-C ke board-C, untuk plan_c_id diisi nanti oleh id plan-C
    */
    public function getNewBoardC($clsPlanC) {
        $qBoard = $this->getSummaryByIdBuilder()
                        ->havingRaw("count(no_urut) < " . $this->maxUrut)
                        ->orderBy('id')
                        ->lockForUpdate()
                        ->first();
        if (empty($qBoard)) {
            $board = (object) array('id' => 1, 
                                    'plan_c_id' => 0,
                                    'parent_id' => 0,
                                    'no_urut'   => 0);
        } else {
            $board = $this->where('id', '=', $qBoard->id)->orderBy('no_urut', 'desc')
                                ->lockForUpdate()
                                ->first();
        }
        $lastBoard = $this->getLastBoard();
        $board->no_urut += 1;
        $topData = (in_array($board->no_urut, [4, 7, 10, 13])) ? $this->getDataBoardByUrut($board->id, $this->getTopUrut($board->no_urut)) : null;
        $flyBoard = ($board->no_urut >= $this->maxUrut) ? $this->getDataBoardByUrut($board->id, 1) : null;
        $flyUser = (!empty($flyBoard)) ? $clsPlanC->getInfoUserFromBoard($flyBoard) : null;
        $topUser = (!empty($topData)) ? $clsPlanC->getInfoUserFromBoard($topData) : null;
        return (object) array('id'      => $board->id, // id board
                            'plan_c_id' => 0, // id plan-C, diisi nanti
                            'parent_id' => $board->parent_id, // last board id
                            'no_urut'   => $board->no_urut, // no urut baru
                            'penuh'     => ($board->no_urut >= $this->maxUrut), // board penuh / belum
                            'selected_board'=> $this->getBoardById($board->id), // board yg dipilih
                            'lastBoard'   => $lastBoard,    // board terakhir (global), berguna untuk proses fly untuk mendapatkan id board berikutnya
                            'top_data'  => $topData,     //  jika yg masuk ini membuat penuh top struktur / titik ke-3 bagi topline, digunakan untuk bonus plan-C
                            'top_user'  => $topUser, // user data yg di atasnya, diisi oleh yg panggil function ini
                            'fly_user'  => $flyUser // user data yg di atasnya, diisi oleh yg panggil function ini
                            );
    }

    /*
    **  createBoard => insert new plan-C ke board
    **  @values => array, in value data
    **  @newBoard => out object row new board
    **  return boolean
    */
    private function createBoard($values, &$newBoard) {
        try {
            $newBoard = $this->create($values);
            return true;
        } catch (\Exception $e) {
        }
        return false;
    }

    private function getTopUrut($urut) {
        $result = array('1' => 0,
                        '2' => 1,
                        '3' => 1,
                        '4' => 1,
                        '5' => 2,
                        '6' => 2,
                        '7' => 2,
                        '8' => 3,
                        '9' => 3,
                        '10' => 3,
                        '11' => 4,
                        '12' => 4,
                        '13' => 4);
        return array_key_exists($urut, $result) ? $result[$urut] : 0;
    }

    private function getNewUrut($lastUrut) {
        $result = array('1' => -1,
                        '2' => 1,
                        '3' => 1,
                        '4' => 1,
                        '5' => 2,
                        '6' => 3,
                        '7' => 4,
                        '8' => 2,
                        '9' => 3,
                        '10' => 4,
                        '11' => 2,
                        '12' => 3,
                        '13' => 4);
        return array_key_exists($lastUrut, $result) ? $result[$lastUrut] : -1;
    }

    private function getNewIdBoardByFly($lastUrut, $lastId) {
        $result = array('1' => -1,
                        '2' => $lastId + 1,
                        '3' => $lastId + 2,
                        '4' => $lastId + 3,
                        '5' => $lastId + 1,
                        '6' => $lastId + 1,
                        '7' => $lastId + 1,
                        '8' => $lastId + 2,
                        '9' => $lastId + 2,
                        '10' => $lastId + 2,
                        '11' => $lastId + 3,
                        '12' => $lastId + 3,
                        '13' => $lastId + 3);
        return array_key_exists($lastUrut, $result) ? $result[$lastUrut] : -1;
    }

    private function getChildUrut($urut) {
        $list = array(1 => [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13], 2 => [5, 6, 7], 3 => [8, 9, 10], 4 => [11, 12, 13]);
        $urut = intval($urut);
        return (array_key_exists($urut, $list)) ? $list[$urut] : [];
    }

    private function isValidUrut($urut) {
        $urut = intval($urut);
        return ($urut >= 1 && $urut <= 13);
    }

    private function flyBoardC($selectedBoard, $lastBoard, &$currentBoard) {
        if ($selectedBoard->isEmpty() || $selectedBoard->count() + 1 != $this->maxUrut) return false;
        $valuePecahan   = [];
        $lastIdBoard    = empty($lastBoard) ? 0 : $lastBoard->id;
        $okValid = true;
        $sekarang = date('Y-m-d H:i:s');
        foreach ($selectedBoard as $row) {
            if ($row->no_urut > 1) {
                $newUrut = $this->getNewUrut($row->no_urut);
                $okValid = $this->isValidUrut($newUrut);
                if (!$okValid) break;
                $valuePecahan[] = array('id'        => $this->getNewIdBoardByFly($row->no_urut, $lastIdBoard), 
                                        'plan_c_id' => $row->plan_c_id,
                                        'parent_id' => $row->id,
                                        'no_urut'   => $newUrut,
                                        'created_at'=> $sekarang);
            }
        }
        if (!$okValid) return false;
        $newCurUrut = $this->getNewUrut($currentBoard->no_urut);
        if (!$this->isValidUrut($newCurUrut)) return false;
        $current = array('id'       => $this->getNewIdBoardByFly($currentBoard->no_urut, $lastIdBoard),
                        'plan_c_id' => $currentBoard->plan_c_id,
                        'parent_id' => $selectedBoard[0]->id,
                        'no_urut'   => $newCurUrut);
        $valuePecahan[] = $current;
        $currentBoard = (object) $current;
        if (!empty($valuePecahan) && count($valuePecahan) == $this->maxUrut - 1) {
            try {
                $this->insert($valuePecahan);
                return true;
            } catch (\Exception $e) {
//                dd($e->getMessage());
            }
        }
        return false;
    }

    /*
    **  registerBoardC => mendaftarkan member ke board C
    **  @paramBoard => type object dari getNewBoardC yg sudah diisi plan_c_id-nya sebagai parameter board
    **  @newBoard => out object row new board
    **  return boolean
    */
    public function registerBoardC($clsPlan, $paramBoard, &$newBoard) {
        if (empty($paramBoard) || intval($paramBoard->plan_c_id) == 0 || $paramBoard->no_urut > 13 || $paramBoard->no_urut < 1) return false;
        $board      = null;
        $values     = ['id' => $paramBoard->id, 
                        'plan_c_id' => $paramBoard->plan_c_id, 
                        'parent_id' => $paramBoard->parent_id, 
                        'no_urut' => $paramBoard->no_urut];
        if ($this->createBoard($values, $board)) {
            $clsBonus = new Plan_c_bonus();
            if ($paramBoard->penuh) {
                $valueFly = $paramBoard->selected_board->first();
                if ($this->flyBoardC($paramBoard->selected_board, $paramBoard->lastBoard, $board)) {
                    //  update fly
                    if (!$clsPlan->updateFly($valueFly)) return false;
                    //  insert bonus fly
                    $bonus = null;
                    //if (!$clsBonus->createBonusC3($paramBoard->fly_user, $valueFly->id, $valueFly->plan_c_id, $bonus, 2)) return false;
                    if (!$clsBonus->createBonusC3($paramBoard->fly_user, $valueFly, $bonus, 2)) return false;
                } else {
                    return false;
                }
            }
            if (!empty($paramBoard->top_data)) {
                //  insert bonus top struktur, eg: urut 7, top 2, maka 2 dapat bonus
                $tData = $paramBoard->top_data;
                $bonus = null;
                //if ($clsBonus->createBonusC3($paramBoard->top_user,$tData->id, $tData->plan_c_id, $bonus, 1)) {
                if ($clsBonus->createBonusC3($paramBoard->top_user, $tData, $bonus, 1)) {
                    $clsWd = new Plan_c_wd();
                    if (!$clsWd->createWD($paramBoard->top_user->id, $tData->plan_c_id, $bonus->id, $bonus->bonus_amount, 1)) return false;
                } else {
                    return false;
                }
            }
            $newBoard = $board;
            return true;
        }
        return false;
    }

    /*
    **  getGlobalProgress => mendapatkan persentase progress secara global
    **  return number persent
    */
    public function getGlobalProgress() {
        $qTotalRow = $this->getSummaryByIdBuilder()
                            ->havingRaw(DB::raw("count(no_urut) < " . $this->maxUrut))
                            ->toSql();
        $totalBoardC = DB::table(DB::raw('(' . $qTotalRow . ') as a'))
                            ->selectRaw('count(id) as total_board, sum(jumlah) as total_member')
                            ->first();
        if (empty($totalBoardC)) return 0;
        if ($totalBoardC->total_board == 0) return 0;
        $maxMemberBoardC = $totalBoardC->total_board * $this->maxUrut;
        return ($totalBoardC->total_member * 100) / $maxMemberBoardC;
    }

    public function getGlobalStatisticC() {
        $totalBoard = $this->distinct('id')->count('id');
        $totalAkun  = DB::table('tb_plan_c')->count();
        $maxMember  = $totalBoard * $this->maxUrut;
        $progress   = ($totalAkun == 0) ? 0 : ($totalAkun * 100) / $maxMember;
        return (object) array(
            'today'     => $this->distinct('id')->whereRaw('DATE(created_at) = CURDATE()')->count('id'),
            'yesterday' => $this->distinct('id')
                ->whereRaw('DATE(created_at) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)')
                ->count('id'),
            'total'     => $totalBoard,
            'progress'  => $progress
        );
    }

    private function setStructureHierarchy(array $structure) {
        if (empty($structure)) return [];
        $result = [];
        $L2 = [];
        $L3 = [];
        foreach ($structure as $row) {
            if ($row->board_urut == 1) {
                //$result[] = [$row, []];
                $result[] = "[{v:'" . $row->board_urut . "', f:'<img src=". asset("assets/img/logo-icon.png") ."><span>" . $row->code . "</span>'}, '', '']";
            } elseif (in_array($row->board_urut, [2, 3, 4])) {
                //$result[0][1][$row->board_urut] = [$row, []];
                $result[] = "[{v:'" . $row->board_urut . "', f:'<img src=". asset("assets/img/logo-icon.png") ."><span>" . $row->code . "</span>'}, '" . $this->getTopUrut($row->board_urut) . "', '']";
                $L2[] = $row->board_urut;
            } else {
                //$result[0][1][$row->parent_urut][1][] = $row;
                $result[] = "[{v:'" . $row->board_urut . "', f:'<img src=". asset("assets/img/logo-icon.png") ."><span>" . $row->code . "</span>'}, '" . $this->getTopUrut($row->board_urut) . "', '1']";
                $L3[$this->getTopUrut($row->board_urut)][] = $row->board_urut;
            }
        }
        if (count($result) == 1) {
            for ($i = 2; $i <= 4; $i++) {
                $result[] = "[{v:'" . $i . "', f:'<img src=". asset("assets/img/logo-icon-disabled.png") ."><span></span>'}, '1', '']";
                $childs = $this->getChildUrut($i);
                for ($j = 0; $j < count($childs); $j++) { 
                    $result[] = "[{v:'" . ($childs[$j]) . "', f:'<img src=". asset("assets/img/logo-icon-disabled.png") ."><span></span>'}, '" . $i . "', '1']";
                }
            }
        } else {
            if (empty($L2) || count($L2) < 3) {
                for ($i = 2; $i <= 4; $i++) { 
                    if (!in_array($i, $L2)) {
                        $L2[] = $i;
                        $result[] = "[{v:'" . $i . "', f:'<img src=". asset("assets/img/logo-icon-disabled.png") ."><span></span>'}, '1', '']";
                        $L3[$i] = [];
                    }
                    $cL3 = $this->getChildUrut($i);
                    foreach ($cL3 as $value) {
                        if (!isset($L3[$i])) $L3[$i] = [];
                        if (!in_array($value, $L3[$i])) {
                            $result[] = "[{v:'" . $value . "', f:'<img src=". asset("assets/img/logo-icon-disabled.png") ."><span></span>'}, '" . $i . "', '1']";
                        }
                    }
                }
            } else {
                if (empty($L3) || count($L3) < 9) {
                    for ($i = 5; $i <= 13; $i++) { 
                        $top = $this->getTopUrut($i);
                        if (!in_array($top, $L2)) {
                            $result[] = "[{v:'" . $top . "', f:'<img src=". asset("assets/img/logo-icon-disabled.png") ."><span></span>'}, '1', '']";
                            $L2[] = $top;
                            $L3[$top] = [];
                        }
                        if (!isset($L3[$top])) $L3[$top] = [];
                        if (!in_array($i, $L3[$top])) {
                            $result[] = "[{v:'" . $i . "', f:'<img src=". asset("assets/img/logo-icon-disabled.png") ."><span></span>'}, '" . $top . "', '1']";
                        }
                    }
                }
            }
        }
        return $result;
    }

    public function getMemberProgress($user) {
        function getStructure($id, $noUrut, array $childUruts) {
            array_unshift($childUruts, $noUrut);
            return DB::table('tb_plan_c_board')
                        ->join('tb_plan_c', 'tb_plan_c.id', '=', 'tb_plan_c_board.plan_c_id')
                        ->where('tb_plan_c_board.id', '=', $id)
                        ->whereIn('tb_plan_c_board.no_urut', $childUruts)
                        ->selectRaw("tb_plan_c_board.*, tb_plan_c.plan_c_code")
                        ->orderBy('tb_plan_c_board.no_urut')
                        ->get();
        }
        $result = [];
        if (empty($user)) return $result;
        $qAllBoard = $this->getSummaryByIdBuilder()->toSql();
        $qPlanC = DB::table('tb_plan_c_board')
                        ->join('tb_plan_c', 'tb_plan_c.id', '=', 'tb_plan_c_board.plan_c_id')
                        ->selectRaw("max(tb_plan_c_board.id) as id, tb_plan_c_board.plan_c_id")
                        ->whereRaw("tb_plan_c.user_id = " . $user->id)
                        ->groupBy('tb_plan_c_board.plan_c_id')
                        ->toSql();
        $memberBoard = DB::table('tb_plan_c_board')
                            //  mengambil running board / board terakhir per akun plan-C bila terjadi fly
                            ->join(DB::raw('(' . $qPlanC . ') as b'), function($join) {
                                $join->on('b.id', '=', 'tb_plan_c_board.id')
                                    ->on('b.plan_c_id', '=', 'tb_plan_c_board.plan_c_id');
                            })
                            //  mengambil data plan
                            ->join('tb_plan_c', 'tb_plan_c.id', '=', 'tb_plan_c_board.plan_c_id')
                            ->selectRaw("tb_plan_c_board.*, tb_plan_c.plan_c_code")
                            ->where('tb_plan_c.user_id', '=', $user->id)
                            ->orderBy('tb_plan_c.id')
                            ->orderBy('tb_plan_c_board.no_urut')
                            ->get();
        if ($memberBoard->isEmpty()) return $result;
        foreach ($memberBoard as $row) {
            $struct = getStructure($row->id, $row->no_urut, $this->getChildUrut($row->no_urut));
            $structure = [];
            $urutan = 1;
            foreach ($struct as $r) {
                $structure[] = (object) array('code'    => $r->plan_c_code, 
                                        'board_id'      => $r->id,
                                        'board_urut'    => $urutan,
                                        'parent_urut'   => $this->getTopUrut($urutan));
                $urutan++;
            }
            $structure = $this->setStructureHierarchy($structure);
            $jmlStruktur = $struct->count();
            $result[] = (object) array('code'           => $row->plan_c_code, 
                                        'board_id'      => $row->id,
                                        'board_urut'    => $row->no_urut,
                                        'jml_struktur'  => $jmlStruktur,
                                        'progress'      => ($jmlStruktur * 100) / $this->maxUrut,
                                        'structure'     => $structure);
        }
        return $result;
    }
}

