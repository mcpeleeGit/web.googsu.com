<?php
class weatherforecastController {
    public function defaultMethod(){
        echo '
            [
                {"date":"2020-03-10T22:36:39.7717359+09:00","temperatureC":28,"temperatureF":82,"summary":"Hot"},
                {"date":"2020-03-11T22:36:39.7784364+09:00","temperatureC":44,"temperatureF":111,"summary":"Hot"},
                {"date":"2020-03-12T22:36:39.7784472+09:00","temperatureC":22,"temperatureF":71,"summary":"Sweltering"},
                {"date":"2020-03-13T22:36:39.7784486+09:00","temperatureC":-1,"temperatureF":31,"summary":"Balmy"},
                {"date":"2020-03-14T22:36:39.7784493+09:00","temperatureC":37,"temperatureF":98,"summary":"Scorching"}
            ]
        ';
    }
}
?>

