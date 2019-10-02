<?php
use think\Request;

 function hook($name,$param = null) {
 	if (!$name) {
 		return false;
 	}
 	if ($name == 'adHook') {
 		if (!$param) {
 			return false;
 		}
	    $adList = db('ad')->where('name',$param)->find();
	    if ($adList) {
	        $content = htmlspecialchars_decode($adList['content']);
	    } else {
	        return false;
	    }
		return $content;
 	}
 	
 	if ($name == 'friendlinkHook') {
 		$friendLink = db('Friendlink')->order('sort ASC')->select();
        $friendLink['friendLinkAll'] = false;
        $friendLink['friendLinkIndex'] = false;
        $friendLink['friendLinkNotIndex'] = false;
        
        $request = Request::instance();
        
        foreach ($friendLink as $key => $val) {
            if ($val['type'] == 'all') {
                $friendLink['friendLinkAll'] = true;
            }
            if ($val['type'] == 'index') {
                $friendLink['friendLinkIndex'] = true;
            }
            if ($val['type'] == 'notIndex') {
                $friendLink['friendLinkNotIndex'] = true;
            }
        }
        $html = '';
        if ($friendLink) {
        	$html .= '<div class="friend-link hidden-xs"><ul>';
       		$html .= '<li> 友情链接：</li>';
        	foreach ($friendLink as $key => $v) {
	        	if ($request->module() == 'index') {
	        		if ($v["type"] == "all" || $v["type"] == "index") {
	        			$html .= '<li><a href="' . $v['url'] . '" target="_blank">' . $v["name"] . '</a></li>';
	        		}
	        	} else {
	        		if ($v["type"] == "all" || $v["type"] == "notIndex") {
		        		$html .= '<li><a href="' . $v['url'] . '" target="_blank">' . $v["name"] . '</a></li>';
	        		}
	        	}
        	}
        	$html .= '</ul></div>';
        }
   		return $html;
        
        
 	}
 	
 }
