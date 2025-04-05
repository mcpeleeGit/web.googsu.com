<?php
require('api/board/service/BoardService.php');
require('api/board/dto/BoardListRequestDTO.php');

class BoardController {
    public function lists(){
        $BoardService = new BoardService(Constants::DB_CONN);
        $BoardService->getList(new BoardListRequestDTO());
    }
}
?>


