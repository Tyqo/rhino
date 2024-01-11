// import * as EditorJS from '../vendor/editor.js';
// import * as Header from '/rhino/js/vendor/bundle.js';
// import List from '@editorjs/list';

// Todo: Implement:
// https://codesandbox.io/s/editor-js-data-parser-demo-forked-l1v7v?file=/src/index.js

export default class Editor {
	constructor(selector, contents) {
		let editorData = '';
		if (contents.length > 0) {
			editorData = JSON.parse(contents);
		} 

		this.editor = new EditorJS({
			/** 
			 * Id of Element that should contain the Editor 
			 */
			holder: selector,
	
			/** 
			 * Available Tools list. 
			 * Pass Tool's class or Settings object for each Tool you want to use 
			 */
			tools: {
				header: {
					class: Header,
					inlineToolbar: ['link']
				},
				list: List 
			},

			autofocus: true,
			placeholder: 'Let`s write an awesome story!',
			data: editorData,
			minHeight: 0
		});

	}
	
	save() {
		return new Promise((resolve, reject) => {
			this.editor.save().then((outputData) => {
				// console.log('Article data: ', outputData)
				resolve(outputData);
			}).catch((error) => {
				// console.log('Saving failed: ', error)
				reject(error);
			});
		});
	}
	
	destroy() {
		this.editor.destroy();
	}
}
//# sourceMappingURL=editor.js.map