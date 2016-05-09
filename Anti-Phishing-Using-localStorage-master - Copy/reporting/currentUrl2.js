//grab the current url
document.addEventListener('DOMContentLoaded', function() {
	document.getElementById("rep1").addEventListener("click", function(){
  //var checkPageButton = document.getElementById('checkPage');
  //checkPageButton.addEventListener('click', function() {
    
    chrome.tabs.getSelected(null, function(tab) {
    
		var tabId = tab.id;
		tabUrl = tab.url;
		
		
		//document.getElementById('urlcheck').value = tabUrl;
		//function saveData(tabUrl) {
			var acc = tabUrl
			
		acc = JSON.stringify(acc);
		acc = btoa(acc);
		localStorage.setItem('_acc',acc);
		var c = localStorage.getItem('_acc');
		//alert(c);
		//}
		
		//saveData(tabUrl);
		window.open("reporting/reporting.html");
	});
  }, false);
}, false);


//document.getElementById("demo").value = "Hello JavaScript!";
 