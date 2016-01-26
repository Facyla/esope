/*------------------------------------------------------------------------
	- HTML Table Filter Generator Sorting Feature
	- TF Adapter v1.2 for WebFX Sortable Table 1.12 (Erik Arvidsson) 
	- By Max Guglielmi (tablefilter.free.fr)
	- Licensed under the MIT License
--------------------------------------------------------------------------
Copyright (c) 2009 Max Guglielmi

Permission is hereby granted, free of charge, to any person obtaining
a copy of this software and associated documentation files (the
"Software"), to deal in the Software without restriction, including
without limitation the rights to use, copy, modify, merge, publish,
distribute, sublicense, and/or sell copies of the Software, and to
permit persons to whom the Software is furnished to do so, subject to
the following conditions:

The above copyright notice and this permission notice shall be included
in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY
CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT,
TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
------------------------------------------------------------------------
	- Changelog:
		1.1 [30-09-09] 
		When table is paged now the whole table is sorted and not
		only the current page
		1.2 [05-12-09]
		Added on_before_sort and on_after_sort call-back functions
------------------------------------------------------------------------*/

//edit .sort-arrow.descending / .sort-arrow.ascending in filtergrid.css to reflect any image_path change
var image_path = "img/"; 
var image_blank = "blank.png";

TF.prototype.SetSortTable = function()
{
	var o = this; //TF object
	var f = o.fObj; //TF config object
	var isTFPaged = false;
	
	/*** TF additional events ***/
	//additional paging events for alternating bg issue
	o.Evt._Paging.nextEvt = function(){ if(o.sorted && o.alternateBgs) o.Filter(); }
	o.Evt._Paging.prevEvt = o.Evt._Paging.nextEvt;
	o.Evt._Paging.firstEvt = o.Evt._Paging.nextEvt;
	o.Evt._Paging.lastEvt = o.Evt._Paging.nextEvt;
	o.Evt._OnSlcPagesChangeEvt = o.Evt._Paging.nextEvt;
	/*** ***/
	
	/*** Extension events ***/
	//call-back function before table is sorted
	o.onBeforeSort = f!=undefined && tf_isFn(f.on_before_sort)
						? f.on_before_sort : null;
	//call-back function after table is sorted
	o.onAfterSort = f!=undefined && tf_isFn(f.on_after_sort)
						? f.on_after_sort : null;
	
	/*** SortableTable ***/
	//in case SortableTable class is missing (sortabletable.js) 
	if((typeof SortableTable)=='undefined') return;
	
	//overrides headerOnclick method in order to handle th
	SortableTable.prototype.headerOnclick = function (e) {
		if(!o.sort) return; // TF adaptation
		// find Header element
		var el = e.target || e.srcElement;
		
		while (el.tagName != "TD" && el.tagName != "TH") // TF adaptation
			el = el.parentNode;

		this.sort(SortableTable.msie ? SortableTable.getCellIndex(el) : el.cellIndex);
	};
	
	//overrides initHeader in order to handle filters row position
	SortableTable.prototype.initHeader = function (oSortTypes) {
		if (!this.tHead) return;
		this.headersRow = o.headersRow; // TF adaptation
		var cells = this.tHead.rows[this.headersRow].cells; // TF adaptation
		var doc = this.tHead.ownerDocument || this.tHead.document;
		this.sortTypes = oSortTypes || [];
		var l = cells.length;
		var img, c;
		for (var i = 0; i < l; i++) {
			c = cells[i];
			if (this.sortTypes[i] != null && this.sortTypes[i] != "None") {
				c.style.cursor = 'pointer';
				img = doc.createElement("IMG");
				img.src = image_path + image_blank;
				c.appendChild(img);
				if (this.sortTypes[i] != null)
					c.setAttribute( "_sortType", this.sortTypes[i]);
				if (typeof c.addEventListener != "undefined")
					c.addEventListener("click", this._headerOnclick, false);
				else if (typeof c.attachEvent != "undefined")
					c.attachEvent("onclick", this._headerOnclick);
				else
					c.onclick = this._headerOnclick;
			}
			else
			{
				c.setAttribute( "_sortType", oSortTypes[i] );
				c._sortType = "None";
			}
		}
		this.updateHeaderArrows();
	};
	
	//overrides updateHeaderArrows in order to handle arrows
	SortableTable.prototype.updateHeaderArrows = function () {
		var cells, l, img;
		
		if(o.sortConfig.asyncSort && o.sortConfig.triggerIds!=null)
		{//external headers
			var triggers = o.sortConfig.triggerIds;
			cells = [], l = triggers.length;
			for(var j=0; j<triggers.length; j++)
				cells.push(tf_Id(triggers[j]));
		} else {
			if (!this.tHead) return;
			cells = this.tHead.rows[this.headersRow].cells; //TF adaptation
			l = cells.length;
		}
		for (var i = 0; i < l; i++) {
			if (cells[i].getAttribute('_sortType') != null && cells[i].getAttribute('_sortType') != "None") {
				img = cells[i].lastChild;
				if(img.nodeName.tf_LCase()!='img')
				{//creates images
					img = tf_CreateElm('img',['src', image_path + image_blank]);
					cells[i].appendChild(img);
				}
				if (i == this.sortColumn)
					img.className = "sort-arrow " + (this.descending ? "descending" : "ascending");
				else
					img.className = "sort-arrow";
			}
		}
	};
	
	//overrides getInnerText in order to avoid Firefox unexpected sorting behaviour with untrimmed text elements
	SortableTable.getInnerText = function (oNode) {
		return tf_GetNodeText(oNode); //TF adaptation
	};
	
	//sort types
	var sortTypes = [];	
	for(var i=0; i<o.nbCells; i++)
	{
		var colType;
		
		if(this.sortConfig.sortTypes!=null && this.sortConfig.sortTypes[i]!=null)
		{
			colType = this.sortConfig.sortTypes[i].tf_LCase();
			if(colType=='none') colType = 'None';
		} else {//resolves column types
			if(o.hasColNbFormat && o.colNbFormat[i]!=null)
				colType = o.colNbFormat[i].tf_LCase();
				//colType = 'Number';
			else if(o.hasColDateType && o.colDateType[i]!=null)
				colType = o.colDateType[i].tf_LCase()+'date';
			else
				colType = 'String';
		}
		
		sortTypes.push(colType);
	}
	
	//Custom sort types
	SortableTable.prototype.addSortType( "number", Number );
	SortableTable.prototype.addSortType( "caseinsensitivestring", SortableTable.toUpperCase );
	SortableTable.prototype.addSortType( "date", SortableTable.toDate );
	SortableTable.prototype.addSortType( "string" );
	SortableTable.prototype.addSortType( "us", usNumberConverter );
	SortableTable.prototype.addSortType( "eu", euNumberConverter );
	SortableTable.prototype.addSortType( "dmydate", dmyDateConverter );
	SortableTable.prototype.addSortType( "ymddate", ymdDateConverter );
	SortableTable.prototype.addSortType( "mdydate", mdyDateConverter );
	
	this.st = new SortableTable(this.tbl,sortTypes);
	
	/*** external table headers adapter ***/
	if(this.sortConfig.asyncSort && this.sortConfig.triggerIds!=null)
	{
		var triggers = this.sortConfig.triggerIds;
		for(var j=0; j<triggers.length; j++)
		{
			if(triggers[j]==null) continue;
			var trigger = tf_Id(triggers[j]);
			if(trigger)
			{
				trigger.style.cursor = 'pointer';
				trigger.onclick = function(){ 
					if(o.sort)
						o.st.asyncSort(
							triggers.tf_IndexByValue(this.id,true)
						); 
				}
				trigger.setAttribute( "_sortType", sortTypes[j] );				
			}
		}
	}
	/*** ***/
	
	//Column sort at start
	if(this.sortConfig.sortCol) 
		this.st.sort(
			this.sortConfig.sortCol[0],
			this.sortConfig.sortCol[1]
		);
	
	this.isSortEnabled = true; //sort is set
	
	/*** Sort events ***/
	this.st.onbeforesort = function()
	{
		if(o.onBeforeSort) o.onBeforeSort.call(null, o, o.st.sortColumn);
		o.Sort(); //TF method
		
		/*** sort behaviour for paging ***/
		if(o.paging){ 
			isTFPaged = true;
			o.paging = false;
			o.RemovePaging();			
		}
	}//onbeforesort
	
	this.st.onsort = function()
	{
		o.sorted = true;//table is sorted
		
		//rows alternating bg issue
		if(o.alternateBgs)
		{
			var rows = o.tbl.rows, c = 0;
			
			function setClass(row, i, removeOnly)
			{
				if(removeOnly == undefined) removeOnly = false;
				tf_removeClass(row, o.rowBgEvenCssClass);
				tf_removeClass(row, o.rowBgOddCssClass);
				if(!removeOnly)
					tf_addClass(row, i % 2 ? o.rowBgEvenCssClass : o.rowBgOddCssClass);
			}
			
			for (var i = o.refRow; i < o.nbRows; i++) 
			{
				var isRowValid = rows[i].getAttribute('validRow');
				if(o.paging && rows[i].style.display == '')
				{
					setClass(rows[i], c);
					c++;
					
				} else {
					
					if((isRowValid=='true' || isRowValid==null) && rows[i].style.display == '')
					{
						setClass(rows[i], c);
						c++;
					} else setClass(rows[i], c, true);
				}
			}
		}
		
		//sort behaviour for paging
		if(isTFPaged)
		{
			o.AddPaging(false);
			o.SetPage(o.currentPageNb);
			isTFPaged = false;
		}
		if(o.onAfterSort) o.onAfterSort.call(null,o,o.st.sortColumn);
	}//onsort
}

//Converter fns
function usNumberConverter( s ){
	return tf_removeNbFormat(s,'us');
}

function euNumberConverter( s ){
	return tf_removeNbFormat(s,'eu');
}

function dateConverter( s,format ){
	return tf_formatDate(s, format);
}

function dmyDateConverter( s ){
	return dateConverter(s,'DMY');
}

function mdyDateConverter( s ){
	return dateConverter(s,'MDY');
}

function ymdDateConverter( s ){
	return dateConverter(s,'YMD');
}