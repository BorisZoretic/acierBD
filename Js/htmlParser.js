$(document).on("click",".btnImpression",function(){
	var siblingBefore = $(this).prev();
	var data = siblingBefore.toString();
	siblingBefore.attr("id","printable");
	console.log(data);
	var displayBefore = $(".cursor.clickWeek.underlineBtn").css("display");
	var displayParentBefore = $(".cursor.clickWeek.underlineBtn").closest("td").css("display");
	var displayParentBeforeConge = $(".cursor.clickConge.underlineBtn").closest("td").css("display");
	//$(this).prev().addClass("forceBorder");
	
	$(".cursor.clickWeek.underlineBtn").css("display","none");
	$(".cursor.clickWeek.underlineBtn").closest("td").css("display","none");
	 $(".cursor.clickConge.underlineBtn").closest("td").css("display","none");
	
	 printJS("printable", 'html');
	 
	 $(".cursor.clickWeek.underlineBtn").css("display",displayBefore);
	 $(".cursor.clickWeek.underlineBtn").closest("td").css("display",displayParentBefore);
	 $(".cursor.clickConge.underlineBtn").closest("td").css("display",displayParentBeforeConge);
	 $(this).prev().removeClass("forceBorder");
});


