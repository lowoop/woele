<?php
/**
 * CAdminCLinkPager class file
 * @author Tang Yi <yitang@sohu-inc.com>
 */
class CAdminCLinkPager extends CLinkPager
{
	/**
	 * @var string the CSS class for the first page button.
	 */
	public $firstPageCssClass='first ui-corner-tl ui-corner-bl fg-button ui-button ui-state-default';
	/**
	 * @var string the CSS class for the last page button.
	 */
	public $lastPageCssClass='last ui-corner-tr ui-corner-br fg-button ui-button ui-state-default';
	/**
	 * @var string the CSS class for the previous page button. 
	 */
	public $previousPageCssClass='previous fg-button ui-button ui-state-default';
	/**
	 * @var string the CSS class for the next page button
	 */
	public $nextPageCssClass='next fg-button ui-button ui-state-default';
	/**
	 * @var string the CSS class for the selected page buttons. .
	 */
	public $selectedPageCssClass='ui-state-disabled';
	/**
	 * @var string the CSS class for the internal page buttons.
	 */
	public $internalPageCssClass='fg-button ui-button ui-state-default';
	/**
	 * @var string the CSS class for the hidden page buttons.
	 */
	public $hiddenPageCssClass='ui-state-disabled';

	/**
	 * Executes the widget.
	 * This overrides the parent implementation by displaying the generated page buttons.
	 */
	public function run()
	{
		$pagerhtml=$this->createPageButtons();
		if(empty($pagerhtml))
			return;
		echo '<div class="fg-toolbar ui-toolbar ui-widget-header ui-corner-bl ui-corner-br ui-helper-clearfix"><div class="dataTables_paginate fg-buttonset ui-buttonset fg-buttonset-multi ui-buttonset-multi paging_full_numbers">';
		echo $pagerhtml;
		echo '</div></div>';
	}



	/**
	 * Creates the page buttons.
	 * @return array a list of page buttons (in HTML code).
	 */
	protected function createPageButtons()
	{
		if(($pageCount=$this->getPageCount())<=1)
			return array();

		list($beginPage,$endPage)=$this->getPageRange();
		$currentPage=$this->getCurrentPage(false); // currentPage is calculated in getPageRange()

		// first page
		$pagerhtml=$this->createPageButton($this->firstPageLabel,0,$this->firstPageCssClass,$currentPage<=0,false);

		// prev page
		if(($page=$currentPage-1)<0)
			$page=0;
		$pagerhtml.=$this->createPageButton($this->prevPageLabel,$page,$this->previousPageCssClass,$currentPage<=0,false);

		$pagerhtml.="<span>";
		// internal pages
		for($i=$beginPage;$i<=$endPage;++$i)
			$pagerhtml.=$this->createPageButton($i+1,$i,$this->internalPageCssClass,false,$i==$currentPage);
		$pagerhtml.="</span>";

		// next page
		if(($page=$currentPage+1)>=$pageCount-1)
			$page=$pageCount-1;
		$pagerhtml.=$this->createPageButton($this->nextPageLabel,$page,$this->nextPageCssClass,$currentPage>=$pageCount-1,false);

		// last page
		$pagerhtml.=$this->createPageButton($this->lastPageLabel,$pageCount-1,$this->lastPageCssClass,$currentPage>=$pageCount-1,false);

		return $pagerhtml;
	}

	/**
	 * Creates a page button.
	 * You may override this method to customize the page buttons.
	 * @param string $label the text label for the button
	 * @param integer $page the page number
	 * @param string $class the CSS class for the page button.
	 * @param boolean $hidden whether this page button is visible
	 * @param boolean $selected whether this page button is selected
	 * @return string the generated button
	 */
	protected function createPageButton($label,$page,$class,$hidden,$selected)
	{
		if($hidden || $selected)
			$class.=' '.($hidden ? $this->hiddenPageCssClass : $this->selectedPageCssClass);
		return CHtml::link($label,$this->createPageUrl($page), array('class'=>''.$class)).'&nbsp;';
	}
}