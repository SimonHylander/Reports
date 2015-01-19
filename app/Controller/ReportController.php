<?php

class ReportController extends AppController {

	public function index() {

        if(strpos(php_uname(), "Win") !== false) {
            $dir = "C:\\wamp\\www\\reports\\";
            $href = $dir;
        }else {
            if($_SERVER["SERVER_NAME"] == "app-02.docuonline.com") {
               $dir = "/webapps/app-02/reports/ki/export/";
                $href = "http://app-02.docuonline.com/reports/ki/export/";
            }else {
                $dir = "/webapps/www2.sjukvardsinformation.net/pdfki/";
                $href = "www2.sjukvardsinformation.net/pdfki/";
            }
        }
        $this->set("href",$href);
        $files = array();

        if(!empty($this->request->query["page"])) {
            $currentPage = $this->request->query["page"];
        }else {
            $this->redirect("/Report?page=1");
        }
        $this->set("currentPage", $currentPage);

        if(!empty($this->request->query["search"]) ) {
            $searchDate = $this->request->query["search"];
            foreach(scandir($dir) as $file) {
                if(!is_dir($file)) {
                    if(strpos($file, ".pdf")!== false) {
                        $date = date("Y-m-d", filemtime($dir."/".$file));
                        
			if($date == $searchDate) {
                            
				$files[$file] = filemtime($dir."/".$file);
                        }
                    }
                }
            }
            arsort($files);
            $files = array_keys($files);
            $this->set("searchDate", $searchDate);
        }else {
            foreach(scandir($dir) as $file) {
                if(!is_dir($file)) {
                    if(strpos($file, ".pdf")!== false) {
                        $files[$file] = filemtime($dir."/".$file);
                    }
                }
            }
            arsort($files);
            $files = array_keys($files);
        }

        $pages = array_chunk($files, 10);
        $pageCount = count($pages)-1;

        $this->set("pageCount",$pageCount);
        $this->set("dir",$dir);
        $this->set("files",$files);
        $this->set("pages",$pages);

        $pageButtons = array();

        if($currentPage -2 < 1) {
            $pageCount = ($pageCount>5)?5:$pageCount;
            for($i=1;$i<$pageCount+1;$i++) {
                array_push($pageButtons, $i);
            }
        }else {
            for($i = $currentPage-2;$i<$currentPage+3;$i++) {
                if($i < $pageCount+1) {
                    array_push($pageButtons, $i);
                }
            }
        }
        $this->set("pageButtons", $pageButtons);

        if($currentPage == 1){
            $previousPage = 1;
        }else {
            $previousPage = $currentPage-1;
        }
        if($currentPage == $pageCount){
            $nextPage = $currentPage;
        }else {
            $nextPage = $currentPage+1;
        }

        $this->set("previousPage", $previousPage);
        $this->set("nextPage", $nextPage);
	}

    public function search() {
        if(!empty($this->request->query["search"]) ) {
            $searchDate = $this->request->query["search"];
            $this->redirect("/Report?search=".$searchDate."&page=1");
        }
    }

}
