	HTMLArea.loadPlugin("ContextMenu");
	HTMLArea.loadPlugin("TableOperations");

	function initDocument() {
		var editor = null;
		var editor = new HTMLArea("htmlarea");

		editor.registerPlugin(ContextMenu);

		var cfg = editor.config;
		cfg.toolbar = [
			[ "fontname", "space",
			"fontsize", "space",
			"formatblock", "space",
			"bold", "italic", "underline", "strikethrough", "separator",
			"subscript", "superscript", "separator",
			"copy", "cut", "paste", "space", "undo", "redo" ],
	
			[ "justifyleft", "justifycenter", "justifyright", "justifyfull", "separator",
			"lefttoright", "righttoleft", "separator",
			"insertorderedlist", "insertunorderedlist", "outdent", "indent", "separator",
			"forecolor", "hilitecolor", "separator",
			"inserthorizontalrule", "createlink", "insertimage", "inserttable", "htmlmode", "separator",
			"about" ]
		];

		editor.registerPlugin(TableOperations);

		editor.generate();
      }