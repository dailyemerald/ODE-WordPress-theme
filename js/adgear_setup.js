CPN_PARTNER = "false";
(function() {
	var _r = Math.floor(Math.random()*1000000);
	if (_r < 300000) {
		CPN_PARTNER = "true";
	}
})();

(function() {
  var proto = "http:";
  var host = "cdn.adgear.com";
  var bucket = "a";
  if (window.location.protocol == "https:") {
    proto = "https:";
    host = "a.adgear.com";
    bucket = "";
  }
  document.writeln('<scr' + 'ipt type="text/ja' + 'vascr' + 'ipt" s' + 'rc="' +
      proto + '//' + host + '/' + bucket + '/adgear.js/current/adgear.js' +
      '"></scr' + 'ipt>');
})();

ADGEAR.tags.script.init();
ADGEAR.lang.namespace("ADGEAR.site_callbacks");
ADGEAR.site_callbacks.variables = function() {
	return { };
}

ADGEAR.site_callbacks.variables = function() {
return { "CPN_PARTNER": CPN_PARTNER }; }


var anCPCd = "WP";
var anCPPipe = "1";
var anCPPaperId = "859";
var anCPPaperName = "Oregon Daily Emerald";
var anCPPaperUrl = location.host;

var adGearSeg_Format_id="";
var adGearSeg_ChipKey="";
var adGearSeg_ContainerID="";
var adGearSeg_path="";
var adGearSeg_adPaperID= anCPPaperId;
var adGearSeg_Section="";
var adGearSeg_Zone=adGearSeg_Section;
var adGearSeg_div=",";
var papername=anCPPaperName;



