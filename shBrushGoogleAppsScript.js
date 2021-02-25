;(function()
{
  // CommonJS
  SyntaxHighlighter = SyntaxHighlighter || (typeof require !== 'undefined'? require('shCore').SyntaxHighlighter : null);

  function Brush()
  {
		// https://flaviocopes.com/javascript-reserved-words/
		var keywords =	'await break case catch class const continue debugger default delete ' +
						'do else enum export extends false finally for function if  ' +
						'implements import in instanceof interface let new null package private ' +
						'protected public return super switch static this throw try true ' +
						'typeof var void while with yield     ';
		
		// https://github.com/selectnull/eslint-plugin-googleappsscript/blob/master/lib/index.js
		var services = 'AdSense AdminDirectory AdminGroupsMigration AdminGroupsSettings AdminLicenseManager AdminReports AdminReseller Analytics AnalyticsReporting ' +
						'AppsActivity BigQuery Browser CacheService Calendar CalendarApp CardService Charts Classroom ContactsApp ' +
						'ContentService DataStudioApp Docs DocumentApp DoubleClickCampaigns Drive DriveActivity DriveApp FormApp FusionTables ' +
						'Gmail GmailApp GroupsApp HtmlService Jdbc LanguageApp LinearOptimizationService LockService Logger MailApp ' +
						'Maps MimeType Mirror People PropertiesService ScriptApp Session Sheets ShoppingContent SitesApp ' +
						'Slides SlidesApp SpreadsheetApp TagManager Tasks UrlFetchApp Utilities XmlService YouTube YouTubeAnalytics ' +
						'YouTubeContentId console';


		var r = SyntaxHighlighter.regexLib;
		
		this.regexList = [
			{ regex: r.multiLineDoubleQuotedString,					css: 'string' },			// double quoted strings
			{ regex: r.multiLineSingleQuotedString,					css: 'string' },			// single quoted strings
			{ regex: r.singleLineCComments,							css: 'comments' },			// one line comments
			{ regex: r.multiLineCComments,							css: 'comments' },			// multiline comments
			{ regex: /\s*#.*/gm,									css: 'preprocessor' },		// preprocessor tags like #region and #endregion
			{ regex: new RegExp(this.getKeywords(keywords), 'gm'),	css: 'keyword' },			// keywords
			{ regex: new RegExp(this.getKeywords(services), 'gm'),	css: 'service' }			// keywords
			];
	
		this.forHtmlScript(r.scriptScriptTags);
	};

  Brush.prototype  = new SyntaxHighlighter.Highlighter();
  Brush.aliases  = ['Google Apps Script', 'gs', 'gas'];

  SyntaxHighlighter.brushes.GoogleAppsScript= Brush;

  // CommonJS
  typeof(exports) != 'undefined' ? exports.Brush = Brush : null;
})();
