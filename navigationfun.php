<?php
include_once("connect.php");
///public $con;
$con=new connect();
$con->connectdb();
function getPagingQuery($sql, $itemPerPage = 10)
{
	if (isset($_GET['page']) && (int)$_GET['page'] > 0) {
		$page = (int)$_GET['page'];
	} else 
	{
		$page = 1;
	}
	
	// start fetching from this row number
	$offset = ($page - 1) * $itemPerPage;
	return $sql . " LIMIT $offset, $itemPerPage";
}

function dbNumRows($result)
{
	return mysqli_num_rows($result);
}
function dbFetchAssoc($result)
{
	return $result->fetch_assoc();
}
function dbQuery($sql)
{
	global $con;
	$result = $con->selectdb($sql);// mysql_query($sql) or die(mysql_error());
	return $result;
}

function dbAffectedRows()
{
	global $dbConn;
	return mysqli_affected_rows($dbConn);
}

function dbFetchArray($result, $resultType = MYSQL_NUM) 
{
	//global $con;
	return mysqli_fetch_array($result, $resultType);
}
function dbFetchRow($result) 
{
	return mysqli_fetch_row($result);
}

function dbFreeResult($result)
{
	return mysqli_free_result($result);
}

function dbSelect($dbName)
{
global $con;
	return mysqli_select_db($con->getConnection(),$dbName);
}

function dbInsertId()
{
global $con;
	return mysqli_insert_id($con->getConnection());
}




function getPagingLink($sql, $itemPerPage = 10, $strGet = '')
{
//echo $id;die;
	global $con;
	$result        =  mysqli_query($con->getConnection(),$sql);
	//echo $sql;
	$pagingLink    = '';
	$totalResults  = dbNumRows($result);
	//echo $totalResults;
	$totalPages    = ceil($totalResults / $itemPerPage);
	//echo $totalPages;
	
	// how many link pages to show
	$numLinks      = 10;
	if ($totalPages > 1) {
	
		$self = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] ;
		if (isset($_GET['page']) && (int)$_GET['page'] > 0) {
			$pageNumber = (int)$_GET['page'];
		} else 
		{
			$pageNumber = 1;
		}
		
		// print 'previous' link only if we're not
		// on page one
		if ($pageNumber > 1) {
			$page = $pageNumber - 1;
			if ($page > 1) {
				$prev = " <li><a href=\"$self?page=$page&$strGet\" >[Prev]</a></li> ";
			} else {
				$prev = " <li><a href=\"$self?$strGet\" >[Prev]</a></li> ";
			}	
				
			$first = "<li> <a href=\"$self?$strGet\" >[First]</a></li> ";
		} else {
			$prev  = ''; // we're on page one, don't show 'previous' link
			$first = ''; // nor 'first page' link
		}
	
		// print 'next' link only if we're not
		// on the last page
		if ($pageNumber < $totalPages) {
			$page = $pageNumber + 1;
			$next = " <li><a href=\"$self?page=$page&$strGet\" >[Next]</a></li> ";
			$last = "<li> <a href=\"$self?page=$totalPages&$strGet\">[Last]</a></li> ";
		} else {
			$next = ''; // we're on the last page, don't show 'next' link
			$last = ''; // nor 'last page' link
		}

		$start = $pageNumber - ($pageNumber % $numLinks) + 1;
		$end   = $start + $numLinks - 1;		
		
		$end   = min($totalPages, $end);
		
		$pagingLink = array();
		for($page = $start; $page <= $end; $page++)	{
			if ($page == $pageNumber) {
				$pagingLink[] = "  <li><a rel=\"nofollow\" href=\"#\" style=\"color:#0000FF\" >$page</a></li> ";   // no need to create a link to current page
				//$pagingLink[] ="<td class='pagenobox'><div class='pagenobox' align='center'>$page</div></td>";
			} else {
				if ($page == 1) {
					$pagingLink[] = " <li><a href=\"$self?$strGet\" >$page</a></li> ";
				} else {	
					$pagingLink[] = " <li><a href=\"$self?page=$page&$strGet\">$page</a></li> ";
				}	
			}
	
		}
		
		$pagingLink = implode('  ', $pagingLink);
		
		// return the page navigation link
		$pagingLink = $first . $prev . $pagingLink . $next . $last;
	}
	
	return $pagingLink;
}


function getPagingLinkAdmin($sql, $itemPerPage = 10, $strGet = '')
{
//echo $id;die;
	global $con;
	$result        =  mysqli_query($con->getConnection(),$sql);
	//echo $sql;
	$pagingLink    = '';
	$totalResults  = dbNumRows($result);
	//echo $totalResults;
	$totalPages    = ceil($totalResults / $itemPerPage);
	//echo $totalPages;
	
	// how many link pages to show
	$numLinks      = 10;
	if ($totalPages > 1) {
	
		$self = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] ;
		if (isset($_GET['page']) && (int)$_GET['page'] > 0) {
			$pageNumber = (int)$_GET['page'];
		} else 
		{
			$pageNumber = 1;
		}
		
		// print 'previous' link only if we're not
		// on page one
		if ($pageNumber > 1) {
			$page = $pageNumber - 1;
			if ($page > 1) {
				$prev = " <a href=\"$self?page=$page&$strGet\" >[Prev]</a>";
			} else {
				$prev = " <a href=\"$self?$strGet\" >[Prev]</a>";
			}	
				
			$first = " <a href=\"$self?$strGet\" >[First]</a> ";
		} else {
			$prev  = ''; // we're on page one, don't show 'previous' link
			$first = ''; // nor 'first page' link
		}
	
		// print 'next' link only if we're not
		// on the last page
		if ($pageNumber < $totalPages) {
			$page = $pageNumber + 1;
			$next = " <a href=\"$self?page=$page&$strGet\" >[Next]</a>";
			$last = " <a href=\"$self?page=$totalPages&$strGet\">[Last]</a>";
		} else {
			$next = ''; // we're on the last page, don't show 'next' link
			$last = ''; // nor 'last page' link
		}

		$start = $pageNumber - ($pageNumber % $numLinks) + 1;
		$end   = $start + $numLinks - 1;		
		
		$end   = min($totalPages, $end);
		
		$pagingLink = array();
		for($page = $start; $page <= $end; $page++)	{
			if ($page == $pageNumber) {
				$pagingLink[] = "  <a rel=\"nofollow\" href=\"#\" style=\"color:#0000FF\" >$page</a> ";   // no need to create a link to current page
				//$pagingLink[] ="<td class='pagenobox'><div class='pagenobox' align='center'>$page</div></td>";
			} else {
				if ($page == 1) {
					$pagingLink[] = " <a href=\"$self?$strGet\" >$page</a> ";
				} else {	
					$pagingLink[] = " <a href=\"$self?page=$page&$strGet\">$page</a> ";
				}	
			}
	
		}
		
		$pagingLink = implode('  ', $pagingLink);
		
		// return the page navigation link
		$pagingLink = $first . $prev . $pagingLink . $next . $last;
	}
	
	return $pagingLink;
}


function getPagingLinkinner($sql, $itemPerPage = 10,$strGet = '', $id)
{
	
//echo $id;die;
	global $con;
	$result        =  mysqli_query($con->getConnection(),$sql);
	//echo $sql;
	$pagingLink    = '';
	$totalResults  = dbNumRows($result);
	//echo $totalResults;
	$totalPages    = ceil($totalResults / $itemPerPage);
	//echo $totalPages;
	
	// how many link pages to show
	$numLinks      = 10;
	if ($totalPages > 1) {
	
		$self = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] ;
		if (isset($_GET['page']) && (int)$_GET['page'] > 0) {
			$pageNumber = (int)$_GET['page'];
		} else 
		{
			$pageNumber = 1;
		}
		
		// print 'previous' link only if we're not
		// on page one
		if ($pageNumber > 1) {
			$page = $pageNumber - 1;
			if ($page > 1) {
				$prev = " <li><a class=\"prev page-numbers\" href=\"$self?page=$page&id=$id&$strGet\" ><i class=\"fa fa-angle-left\"></i> Prev</a> </li>";
			} else {
				$prev = " <li><a class=\"prev page-numbers\" href=\"$self?id=$id&$strGet\" ><i class=\"fa fa-angle-left\"></i> Prev</a></li> ";
			}	
				
			//$first = " <li><a href=\"$self?id=$id&$strGet\" >[First]</a> </li>";
		} else {
			$prev  = ''; // we're on page one, don't show 'previous' link
			//$first = ''; // nor 'first page' link
		}
	
		// print 'next' link only if we're not
		// on the last page
		if ($pageNumber < $totalPages) {
			$page = $pageNumber + 1;
			$next = "<li> <a class=\"next page-numbers\" href=\"$self?page=$page&id=$id&$strGet\" >Next <i class=\"fa fa-angle-right\"></i></a></li> ";
			//$last = " <li><a href=\"$self?page=$totalPages&id=$id&$strGet\">[Last]</a></li> ";
		} else {
			$next = ''; // we're on the last page, don't show 'next' link
			$last = ''; // nor 'last page' link
		}

		$start = $pageNumber - ($pageNumber % $numLinks) + 1;
		$end   = $start + $numLinks - 1;		
		
		$end   = min($totalPages, $end);
		
		$pagingLink = array();
		for($page = $start; $page <= $end; $page++)	{
			if ($page == $pageNumber) {
				$pagingLink[] = "<li> <span class=\"page-numbers current\">$page</span> </li>";   // no need to create a link to current page
				//$pagingLink[] ="<td class='pagenobox'><div class='pagenobox' align='center'>$page</div></td>";
			} else {
				if ($page == 1) {
					$pagingLink[] = "<li><a class=\"page-numbers\" href=\"$self?id=$id&$strGet\" >$page</a></li> ";
				} else {	
					$pagingLink[] = "<li><a class=\"page-numbers\" href=\"$self?id=$id&page=$page&$strGet\">$page</a></li> ";
				}	
			}
	
		}
		
		$pagingLink = implode('  ', $pagingLink);
		
		// return the page navigation link
		$pagingLink = $prev . $pagingLink . $next ;
	}
	
	return $pagingLink;
}


function getPagingLinkdetail($sql, $itemPerPage = 10,$strGet = '', $id,$catid)
{
	
//echo $id;die;
	global $con;
	$result        =  mysqli_query($con->getConnection(),$sql);
	//echo $sql;
	$pagingLink    = '';
	$totalResults  = dbNumRows($result);
	//echo $totalResults;
	$totalPages    = ceil($totalResults / $itemPerPage);
	//echo $totalPages;
	
	// how many link pages to show
	$numLinks      = 10;
	if ($totalPages > 1) {
	
		$self = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] ;
		if (isset($_GET['page']) && (int)$_GET['page'] > 0) {
			$pageNumber = (int)$_GET['page'];
		} else 
		{
			$pageNumber = 1;
		}
		
		// print 'previous' link only if we're not
		// on page one
		if ($pageNumber > 1) {
			$page = $pageNumber - 1;
			if ($page > 1) {
				$prev = " <a href=\"$self?page=$page&id=$id&$strGet\" >[Prev]</a> ";
			} else {
				$prev = " <a href=\"$self?id=$id&$strGet\" >[Prev]</a> ";
			}	
				
			$first = " <a href=\"$self?id=$id&$strGet\" >[First]</a> ";
		} else {
			$prev  = ''; // we're on page one, don't show 'previous' link
			$first = ''; // nor 'first page' link
		}
	
		// print 'next' link only if we're not
		// on the last page
		if ($pageNumber < $totalPages) {
			$page = $pageNumber + 1;
			$next = " <a href=\"$self?page=$page&id=$id&catId=$catid&$strGet\" >[Next]</a> ";
			$last = " <a href=\"$self?page=$totalPages&id=$id&$strGet\">[Last]</a> ";
		} else {
			$next = ''; // we're on the last page, don't show 'next' link
			$last = ''; // nor 'last page' link
		}

		$start = $pageNumber - ($pageNumber % $numLinks) + 1;
		$end   = $start + $numLinks - 1;		
		
		$end   = min($totalPages, $end);
		
		$pagingLink = array();
		for($page = $start; $page <= $end; $page++)	{
			if ($page == $pageNumber) {
				$pagingLink[] = " $page ";   // no need to create a link to current page
				//$pagingLink[] ="<td class='pagenobox'><div class='pagenobox' align='center'>$page</div></td>";
			} else {
				if ($page == 1) {
					$pagingLink[] = " <a href=\"$self?$strGet\" >$page</a> ";
				} else {	
					$pagingLink[] = " <a href=\"$self?page=$page&$strGet\">$page</a> ";
				}	
			}
	
		}
		
		$pagingLink = implode(' | ', $pagingLink);
		
		// return the page navigation link
		$pagingLink = $first . $prev . $pagingLink . $next . $last;
	}
	
	return $pagingLink;
}

function getPagingLinkUser($sql, $itemPerPage = 3, $strGet = '')
{
//echo $id;die;
	global $con;
	$result        =  mysqli_query($con->getConnection(),$sql);
	//echo $sql;
	$pagingLink    = '';
	$totalResults  = dbNumRows($result);
	//echo $totalResults;
	$totalPages    = ceil($totalResults / $itemPerPage);
	//echo $totalPages;
	
	// how many link pages to show
	$numLinks      = 10;
	if ($totalPages > 1) {
	
		$self = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] ;
		if (isset($_GET['page']) && (int)$_GET['page'] > 0) {
			$pageNumber = (int)$_GET['page'];
		} else 
		{
			$pageNumber = 1;
		}
		//echo $pageNumber." pagenumber<br>";
		// print 'previous' link only if we're not
		// on page one
		if ($pageNumber > 1) {
			$page = $pageNumber - 1;
			if ($page > 1) {
				$prev = " <li><a rel=\"nofollow\" href=\"$self?page=$page&$strGet\" >Previous</a></li> ";
			} else {
				$prev = " <li><a rel=\"nofollow\" href=\"$self?page=$page&$strGet\" >Previous</a></li>";
			}	
				
			$first = " <li> <a rel=\"nofollow\" href=\"$self?$strGet\" >First</a></li> ";
		} else {
			$prev  = ''; // we're on page one, don't show 'previous' link
			$first = ''; // nor 'first page' link
		}
	
		// print 'next' link only if we're not
		// on the last page
		if ($pageNumber < $totalPages) {
			$page = $pageNumber + 1;
			$next = " <li><a rel=\"nofollow\" href=\"$self?page=$page&$strGet\" >Next</a></li>  ";
			$last = " <li><a rel=\"nofollow\" href=\"$self?page=$totalPages&$strGet\">Last</a></li> ";
			
		} else {
			$next = ''; // we're on the last page, don't show 'next' link
			$last = ''; // nor 'last page' link
		}

		$start = $pageNumber - ($pageNumber % $numLinks) + 1;
		$end   = $start + $numLinks - 1;		
		
		$end   = min($totalPages, $end);
		//echo $start." start<br>";
		//echo $end." end<br>";
		//echo $page." page<br>";
		$pagingLink = array();
		for($page = $start; $page <= $end; $page++)	{
			if ($page == $pageNumber) {
				$pagingLink[] = " <li><a rel=\"nofollow\" href=\"#\" style=\"color:#0000FF\" >$page</a></li> ";   // no need to create a link to current page
				//$pagingLink[] ="<td class='pagenobox'><div class='pagenobox' align='center'>$page</div></td>";
			} else {
				if ($page == 1) {
					$pagingLink[] = "<li> <a rel=\"nofollow\" href=\"$self?$strGet\" >$page</a></li>  ";
				} else {	
					$pagingLink[] = " <li><a rel=\"nofollow\" href=\"$self?page=$page&$strGet\">$page</a></li> ";
				}	
			}
	
		}
		
		$pagingLink = implode('  ', $pagingLink);
		
		// return the page navigation link
	
		$pagingLink = $first . $prev . $pagingLink . $next . $last;
	}
	
	return $pagingLink;
}

function getPagingLinkinneradmin($sql, $itemPerPage = 10,$strGet = '', $id)
{
	
//echo $id;die;
	global $con;
	$result        =  mysqli_query($con->getConnection(),$sql);
	//echo $sql;
	$pagingLink    = '';
	$totalResults  = dbNumRows($result);
	//echo $totalResults;
	$totalPages    = ceil($totalResults / $itemPerPage);
	//echo $totalPages;
	
	// how many link pages to show
	$numLinks      = 10;
	if ($totalPages > 1) {
	
		$self = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] ;
		if (isset($_GET['page']) && (int)$_GET['page'] > 0) {
			$pageNumber = (int)$_GET['page'];
		} else 
		{
			$pageNumber = 1;
		}
		
		// print 'previous' link only if we're not
		// on page one
		if ($pageNumber > 1) {
			$page = $pageNumber - 1;
			if ($page > 1) {
				$prev = " <a style=\"color:#000\" href=\"$self?page=$page&id=$id&$strGet\" >[Prev]</a> ";
			} else {
				$prev = " <a style=\"color:#000\" href=\"$self?id=$id&$strGet\" >[Prev]</a> ";
			}	
				
			$first = " <a style=\"color:#000\" href=\"$self?id=$id&$strGet\" >[First]</a> ";
		} else {
			$prev  = ''; // we're on page one, don't show 'previous' link
			$first = ''; // nor 'first page' link
		}
	
		// print 'next' link only if we're not
		// on the last page
		if ($pageNumber < $totalPages) {
			$page = $pageNumber + 1;
			$next = " <a style=\"color:#000\" href=\"$self?page=$page&id=$id&$strGet\" >[Next]</a>";
			$last = " <a style=\"color:#000\" href=\"$self?page=$totalPages&id=$id&$strGet\">[Last]</a> ";
		} else {
			$next = ''; // we're on the last page, don't show 'next' link
			$last = ''; // nor 'last page' link
		}

		$start = $pageNumber - ($pageNumber % $numLinks) + 1;
		$end   = $start + $numLinks - 1;		
		
		$end   = min($totalPages, $end);
		
		$pagingLink = array();
		for($page = $start; $page <= $end; $page++)	{
			if ($page == $pageNumber) {
				$pagingLink[] = " <a style=\"color:#000\" href=\"\" >$page</a> ";   // no need to create a link to current page
				//$pagingLink[] ="<td class='pagenobox'><div class='pagenobox' align='center'>$page</div></td>";
			} else {
				if ($page == 1) {
					$pagingLink[] = " <a style=\"color:#000\" href=\"$self?page=$page&id=$id&$strGet\" >$page</a> ";
				} else {	
					$pagingLink[] = " <a style=\"color:#000\" href=\"$self?page=$page&id=$id&$strGet\">$page</a>";
				}	
			}
	
		}
		
		$pagingLink = implode('  ', $pagingLink);
		
		// return the page navigation link
		$pagingLink = $first . $prev . $pagingLink . $next . $last;
	}
	
	return $pagingLink;
}

function getPagingLinkinnerUser($sql, $itemPerPage = 10,$strGet = '', $text)
{
	
//echo $id;die;
	global $con;
	$result        =  mysqli_query($con->getConnection(),$sql);
	//echo $sql;
	$pagingLink    = '';
	$totalResults  = dbNumRows($result);
	//echo $totalResults;
	$totalPages    = ceil($totalResults / $itemPerPage);
	//echo $totalPages;
	
	// how many link pages to show
	$numLinks      = 10;
	if ($totalPages > 1) {
	
		$self = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] ;
		if (isset($_GET['page']) && (int)$_GET['page'] > 0) {
			$pageNumber = (int)$_GET['page'];
		} else 
		{
			$pageNumber = 1;
		}
		
		// print 'previous' link only if we're not
		// on page one
		if ($pageNumber > 1) {
			$page = $pageNumber - 1;
			if ($page > 1) {
				$prev = " <a style=\"color:#000\" href=\"$self?page=$page&searchtext=$text&$strGet\" >[Prev]</a> ";
			} else {
				$prev = " <a style=\"color:#000\" href=\"$self?searchtext=$text&$strGet\" >[Prev]</a> ";
			}	
				
			$first = " <a style=\"color:#000\" href=\"$self?searchtext=$text&$strGet\" >[First]</a> ";
		} else {
			$prev  = ''; // we're on page one, don't show 'previous' link
			$first = ''; // nor 'first page' link
		}
	
		// print 'next' link only if we're not
		// on the last page
		if ($pageNumber < $totalPages) {
			$page = $pageNumber + 1;
			$next = " <a style=\"color:#000\"  href=\"$self?page=$page&searchtext=$text&$strGet\" >[Next]</a>";
			$last = " <a style=\"color:#000\" href=\"$self?page=$totalPages&searchtext=$text&$strGet\">[Last]</a> ";
		} else {
			$next = ''; // we're on the last page, don't show 'next' link
			$last = ''; // nor 'last page' link
		}

		$start = $pageNumber - ($pageNumber % $numLinks) + 1;
		$end   = $start + $numLinks - 1;		
		
		$end   = min($totalPages, $end);
		
		$pagingLink = array();
		for($page = $start; $page <= $end; $page++)	{
			if ($page == $pageNumber) {
				$pagingLink[] = " <a style=\"color:#000\" href=\"\" >$page</a> ";   // no need to create a link to current page
				//$pagingLink[] ="<td class='pagenobox'><div class='pagenobox' align='center'>$page</div></td>";
			} else {
				if ($page == 1) {
					$pagingLink[] = " <a style=\"color:#000\" href=\"$self?page=$page&searchtext=$text&$strGet\" >$page</a> ";
				} else {	
					$pagingLink[] = " <a style=\"color:#000\" href=\"$self?page=$page&searchtext=$text&$strGet\">$page</a>";
				}	
			}
	
		}
		
		$pagingLink = implode('  ', $pagingLink);
		
		// return the page navigation link
		$pagingLink = $first . $prev . $pagingLink . $next . $last;
	}
	
	return $pagingLink;
}



?>
