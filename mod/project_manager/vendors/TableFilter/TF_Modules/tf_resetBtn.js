/*------------------------------------------------------------------------
	- HTML Table Filter Generator 
	- Reset button (clear filters) feature v1.0
	- By Max Guglielmi (tablefilter.free.fr)
	- Licensed under the MIT License
-------------------------------------------------------------------------*/

TF.prototype.SetResetBtn = function()
/*====================================================
	- Generates reset button
=====================================================*/
{
	if(!this.hasGrid && !this.isFirstLoad) return;
	if( this.btnResetEl!=null ) return;
	var resetspan = tf_CreateElm('span',['id',this.prfxResetSpan+this.id]);
	
	// reset button is added to defined element
	if(this.btnResetTgtId==null) this.SetTopDiv();
	var targetEl = ( this.btnResetTgtId==null ) ? this.rDiv : tf_Id( this.btnResetTgtId );
	targetEl.appendChild(resetspan);

	if(this.btnResetHtml==null)
	{	
		var fltreset = tf_CreateElm( 'a', ['href','javascript:void(0);'] );
		fltreset.className = this.btnResetCssClass;
		fltreset.appendChild(tf_CreateText(this.btnResetText));
		resetspan.appendChild(fltreset);
		fltreset.onclick = this.Evt._Clear;
	} else {
		resetspan.innerHTML = this.btnResetHtml;
		var resetEl = resetspan.firstChild;
		resetEl.onclick = this.Evt._Clear;
	}
	this.btnResetEl = tf_Id(this.prfxResetSpan+this.id).firstChild;	
}

TF.prototype.RemoveResetBtn = function()
/*====================================================
	- Removes reset button
=====================================================*/
{
	if(!this.hasGrid) return;
	if( this.btnResetEl==null ) return;
	var resetspan = tf_Id(this.prfxResetSpan+this.id);
	if( resetspan!=null )
		resetspan.parentNode.removeChild( resetspan );
	this.btnResetEl = null;	
}