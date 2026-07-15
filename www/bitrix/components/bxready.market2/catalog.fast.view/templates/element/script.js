(function() {
	'use strict';

	if (!!window.JCIblockVoteStars)
		return;

	window.JCIblockVoteStars = function (params)
	{
		this.progressId = params.progressId;
		this.ratingId = params.ratingId;
		this.starsId = params.starsId;
		this.ajaxUrl = params.ajaxUrl;
		this.voteId = params.voteId;
		this.starsObj = null;
		this.votedValue = null;
		this.preVotedValue = null;
	};

	window.JCIblockVoteStars.prototype.setValue = function(value)
	{
		value = parseInt(value);
		if (isNaN(value))
			value = 0;
		else if(value > 100)
			value = 100;
		else if(value < 0)
			value = 0;

		var progressObj = BX(this.progressId);

		if(!!progressObj)
		{
			progressObj.style.width = parseInt(value)+"%";
			this.votedValue = value;
		}
	};

	window.JCIblockVoteStars.prototype.setVotes = function(value)
	{
		var ratingObj = BX(this.ratingId);

		if(!!ratingObj)
			ratingObj.innerHTML = "( "+value+" )";
	};

	window.JCIblockVoteStars.prototype.getStarsObj = function()
	{
		if(!this.starsObj)
			this.starsObj = BX(this.starsId);

		return this.starsObj;
	};

	/*todo: IE 8 has no pageX, pageY.*/
	window.JCIblockVoteStars.prototype.onMouseMove = function(event)
	{
		var starsPos = BX.pos(this.getStarsObj());

		var voteValue = (event.pageX - starsPos.left)/starsPos.width*5;

		for (var i = 1; i <= 5; i++)
		{
			if(voteValue < i)
			{
				voteValue = i;
				break;
			}
		}

		this.setValue(voteValue*20);
	};

	window.JCIblockVoteStars.prototype.onMouseOver = function(event)
	{
		BX.bind(this.getStarsObj(), 'click', BX.proxy(this.onVote, this));
		this.preVotedValue = this.votedValue;
	};

	window.JCIblockVoteStars.prototype.onMouseOut = function(event)
	{
		BX.unbind(this.getStarsObj(), 'click', BX.proxy(this.onVote, this));
		this.votedValue = this.preVotedValue;
		this.setValue(this.votedValue);
	};

	window.JCIblockVoteStars.prototype.onVote = function(event)
	{
		this.unBindEvents();

		this.ajaxParams.rating = parseInt(this.votedValue/20)-1;
		this.ajaxParams.vote = "Y";
		this.ajaxParams.vote_id = this.voteId;

		BX.ajax({
			timeout:   30,
			method:   'POST',
			dataType: 'json',
			url:       this.ajaxUrl,
			data:      this.ajaxParams,
			onsuccess: BX.delegate(this.SetResult, this)
		});
	};

	window.JCIblockVoteStars.prototype.SetResult = function(result)
	{
		if (!!result && !result.ERROR)
		{
			this.setValue((result.value)*20);
			this.setVotes(result.votes);
		}
	};

	window.JCIblockVoteStars.prototype.bindEvents = function()
	{
		var starsObj = this.getStarsObj();
		BX.bind(starsObj, 'mousemove', BX.proxy(this.onMouseMove, this));
		BX.bind(starsObj, 'mouseover', BX.proxy(this.onMouseOver, this));
		BX.bind(starsObj, 'mouseout', BX.proxy(this.onMouseOut, this));
	};

	window.JCIblockVoteStars.prototype.unBindEvents = function()
	{
		var starsObj = this.getStarsObj();
		BX.unbind(starsObj, 'mousemove', BX.proxy(this.onMouseMove, this));
		BX.unbind(starsObj, 'mouseover', BX.proxy(this.onMouseOver, this));
		BX.unbind(starsObj, 'mouseout', BX.proxy(this.onMouseOut, this));
		BX.unbind(this.getStarsObj(), 'click', BX.proxy(this.onVote, this));
	};
})();

(function (window) {

    if (!!window.JCShareButtons)
    {
            return;
    }

    window.JCShareButtons = function (containerId)
    {
            if (containerId)
            {
                    var container = BX(containerId);
                    if (container)
                    {
                            this.shareButtons = BX.findChildren(container, {tagName: 'LI'}, true);
                            if (this.shareButtons && this.shareButtons.length >= 1)
                            {
                                    BX.bind(this.shareButtons[this.shareButtons.length-1], 'click', BX.delegate(this.alterVisibility, this));
                            }
                    }
            }
    };

    window.JCShareButtons.prototype.alterVisibility = function()
    {
            if (this.shareButtons && this.shareButtons.length >= 1)
            {
                    for (var i = 0; i < this.shareButtons.length-1; i++)
                    {
                            var li = this.shareButtons[i];
                            li.style.display = li.style.display == "none"? "": "none";
                    }
            }
    };
})(window);

$(document).on('click', '.bxr-share-group', function() {
    $('.bxr-share-icon-wrap').toggle();
});

$(document).on("change", ".bxr-bprop-required", function() {
    $(this).closest('.bxr-bprop-value').removeClass("wrong-bprop");
});