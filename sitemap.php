<?php
include_once("connect.php");
include_once("navigationfun.php");
//include_once("menu.php");
$cn = new connect();
$cn->connectdb();

function getparent($catid)
{
global $cn;
	//$record=$cn->mysql_query("select cat_id,cat_name,cat_parent_id from tbl_category where cat_id=".$catid."");	
	//echo $catid;
	$record=$cn->selectdb("SELECT * FROM tbl_category where cat_id=".$catid."");
	//echo "select cat_id,cat_name,cat_parent_id from tbl_category where cat_id=".$catid."";
	if(dbNumRows($record)>0)
	{
		$sitemap="";
		while($row2 = dbFetchAssoc($record)) 
		{
			extract($row2);
			//$sitemap = $sitemap.$cat_name.">>";
			//$sitemap = $cat_name.">>".$sitemap;
			$sitemap = "<a href='gallerymain.php?id=".$cat_id."' style='text-decoration:none;font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;color:#310101'>".$cat_name."</a>"."&nbsp;&nbsp;&raquo;&nbsp;&nbsp;".$sitemap;
			if($cat_parent_id!=0)
			{
				getparent($cat_parent_id);
			}
			else
			{
			}
			echo $sitemap;
		}
	}
}



function getparentPage($pageid)
{
global $cn;
	//$record=$cn->mysql_query("select cat_id,cat_name,cat_parent_id from tbl_category where cat_id=".$catid."");	
	//echo $catid;
	$record=$cn->selectdb("SELECT * FROM tbl_page where page_id=".$pageid."");
	
	
	//echo "select cat_id,cat_name,cat_parent_id from tbl_category where cat_id=".$catid."";
	if(dbNumRows($record)>0)
	{
		$sitemap="";
		while($row2 = dbFetchAssoc($record)) 
		{
			extract($row2);
			//$sitemap = $sitemap.$cat_name.">>";
			//$sitemap = $cat_name.">>".$sitemap;
			$sitemap = "<li><a href='about/".$page_id."'>".$page_name."</a></li>".$sitemap;
			
			if($page_parent_id!=0)
			{
				getparentPage($page_parent_id);
			}
			else
			{
			}
			echo $sitemap;
		}
	}
}

function getparentEquip($catid)
{
global $cn;
	//$record=$cn->mysql_query("select cat_id,cat_name,cat_parent_id from tbl_category where cat_id=".$catid."");	
	//echo $catid;
	$record=$cn->selectdb("SELECT * FROM tbl_equip_category where cat_id=".$catid."");
	//echo "select cat_id,cat_name,cat_parent_id from tbl_category where cat_id=".$catid."";
	if(dbNumRows($record)>0)
	{
		$sitemap="";
		while($row2 = dbFetchAssoc($record)) 
		{
			extract($row2);
			//$sitemap = $sitemap.$cat_name.">>";
			//$sitemap = $cat_name.">>".$sitemap;
			$sitemap = "<a href='gallerymain.php?id=".$cat_id."' style='text-decoration:none;font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;color:#310101'>".$cat_name."</a>"."&nbsp;&nbsp;&raquo;&nbsp;&nbsp;".$sitemap;
			if($cat_parent_id!=0)
			{
				getparentEquip($cat_parent_id);
			}
			else
			{
			}
			echo $sitemap;
		}
	}
}


function getparentGallery($catid)
{
global $cn;

	//$record=$cn->mysql_query("select cat_id,cat_name,cat_parent_id from tbl_category where cat_id=".$catid."");	
	//echo $catid;
	$record = $cn->selectdb("SELECT * FROM tbl_image_category where cat_id=".$catid."");
	//echo "select cat_id,cat_name,cat_parent_id from tbl_category where cat_id=".$catid."";
	if(dbNumRows($record)>0)
	{
		$sitemap="";
		while($row2 = dbFetchAssoc($record)) 
		{
			extract($row2);
			//$sitemap = $sitemap.$cat_name.">>";
			//$sitemap = $cat_name.">>".$sitemap;
			$sitemap = "<a href='maingallery.php?id=".$cat_id."' style='text-decoration:none;font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;color:#310101'>".$cat_name."</a>"."&nbsp;&nbsp;&raquo;&nbsp;&nbsp;".$sitemap;
			if($cat_parent_id!=0)
			{
				getparentGallery($cat_parent_id);
			}
			else
			{
			}
			echo $sitemap;
		}
	}
}

function getparentVideo($catid)
{
	//$record=$cn->mysql_query("select cat_id,cat_name,cat_parent_id from tbl_category where cat_id=".$catid."");	
	//echo $catid;
	$record=$cn->selectdb("SELECT * FROM tbl_video_category where cat_id=".$catid."");
	//echo "select cat_id,cat_name,cat_parent_id from tbl_category where cat_id=".$catid."";
	if(dbNumRows($record)>0)
	{
		$sitemap="";
		while($row2 = dbFetchAssoc($record)) 
		{
			extract($row2);
			//$sitemap = $sitemap.$cat_name.">>";
			//$sitemap = $cat_name.">>".$sitemap;
			$sitemap = "<a href='maingallery.php?id=".$cat_id."' style='text-decoration:none;font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;color:#310101'>".$cat_name."</a>"."&nbsp;&nbsp;&raquo;&nbsp;&nbsp;".$sitemap;
			if($cat_parent_id!=0)
			{
				getparentVideo($cat_parent_id);
			}
			else
			{
			}
			echo $sitemap;
		}
	}
}

?>