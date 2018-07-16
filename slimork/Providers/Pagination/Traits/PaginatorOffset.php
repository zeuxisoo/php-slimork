<?php
namespace Slimork\Providers\Pagination\Traits;

trait PaginatorOffset {

    public function offset() {
        return ($this->currentPage - 1) * $this->perPage;
    }

}
