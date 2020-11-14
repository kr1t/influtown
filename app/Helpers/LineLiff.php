<?php

namespace Helpers;

class LineLiff
{
    public $baseUrl = "https://liff.line.me/";
    private $data = [

        "register" => [
            "dev" => "1655241745-5JxqyOxP",
        ]

    ];

    public function __get($varName)
    {
        $status = env('LIFF_ENV', 'dev');

        if (!array_key_exists($varName, $this->data)) {
            //this attribute is not defined!

        } else {
            return [
                "key" => $this->data[$varName][$status],
                "url" => "{$this->baseUrl}{$this->data[$varName][$status]}",
            ];
        }
    }

    public function all()
    {
        $status = env('LIFF_ENV', 'dev');

        $datas = [];
        foreach ($this->data as $index => $data) {
            array_push($datas, [
                "key" => $data[$status],
                "url" => "{$this->baseUrl}{$data[$status]}",
                "name" => $index,
            ]);
        }

        return $datas;
    }

    public function get($name, $query = false)
    {
        $query = (array) $query;
        $status = env('LIFF_ENV', 'dev');
        $q = http_build_query($query);
        return "{$this->baseUrl}{$this->data[$name][$status]}?{$q}";
    }
}

function liffAll()
{
    $liff = new LineLiff();

    return $liff->all();
}