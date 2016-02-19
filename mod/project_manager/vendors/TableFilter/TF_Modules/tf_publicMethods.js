/*------------------------------------------------------------------------
	- HTML Table Filter Generator 
	- Additional handy public methods for developers v1.0
	- By Max Guglielmi (tablefilter.free.fr)
	- Licensed under the MIT License
-------------------------------------------------------------------------*/
	
TF.prototype.HasGrid = function()
/*====================================================
	- checks if table has a filter grid
	- returns a boolean
=====================================================*/
{
	return this.hasGrid;
}

TF.prototype.GetFiltersId = function()
/*====================================================
	- returns an array containing filters ids
	- Note that hidden filters are also returned
=====================================================*/
{
	if( !this.hasGrid ) return;
	return this.fltIds;
}

TF.prototype.GetValidRowsIndex = function()
/*====================================================
	- returns an array containing valid rows indexes 
	(valid rows upon filtering)
=====================================================*/
{
	if( !this.hasGrid ) return;
	return this.validRowsIndex;
}

TF.prototype.GetFiltersRowIndex = function()
/*====================================================
	- Returns the index of the row containing the 
	filters
=====================================================*/
{
	if( !this.hasGrid ) return;
	return this.filtersRowIndex;
}

TF.prototype.GetHeadersRowIndex = function()
/*====================================================
	- Returns the index of the headers row
=====================================================*/
{
	if( !this.hasGrid ) return;
	return this.headersRow;
}

TF.prototype.GetStartRowIndex = function()
/*====================================================
	- Returns the index of the row from which will 
	start the filtering process (1st filterable row)
=====================================================*/
{
	if( !this.hasGrid ) return;
	return this.refRow;
}

TF.prototype.GetLastRowIndex = function()
/*====================================================
	- Returns the index of the last row
=====================================================*/
{
	if( !this.hasGrid ) return;
	return (this.nbRows-1);
}

TF.prototype.AddPaging = function(filterTable)
/*====================================================
	- Adds paging feature if filter grid bar is 
	already set
	- Param(s):
		- execFilter: if true table is filtered 
		(boolean)
=====================================================*/
{
	if( !this.hasGrid || this.paging ) return;
	this.paging = true; 
	this.isPagingRemoved = true; 
	this.SetPaging();
	if(filterTable) this.Filter();
}

TF.prototype.GetHeaderElement = function(colIndex)
/*====================================================
	- returns a header DOM element for a given column
	index
=====================================================*/
{
	if( !this.hasGrid ) return null;
	var header;
	var table = (this.gridLayout) ? this.headTbl : this.tbl;
	for(var i=0; i<this.nbCells; i++)
	{
		if(i != colIndex) continue;
		header = table.rows[this.headersRow].cells[i];
		break;
	}
	return header;
}