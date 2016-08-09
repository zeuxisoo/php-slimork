<?php
namespace Simork\Providers\Fractal;

use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\DataArraySerializer;

class Fractal {

    protected $fractal;

    public function __construct() {
        $this->fractal = new Manager();
        $this->fractal->setSerializer(new DataArraySerializer());
    }

    public function collection($items, $transformer) {
        $collection = new Collection($items, $transformer);
        $scope      = $this->fractal->createData($collection);

        return $scope;
    }

    public function item($item, $transformer) {
        $collection = new Item($item, $transformer);
        $scope      = $this->fractal->createData($collection);

        return $scope;
    }

}
