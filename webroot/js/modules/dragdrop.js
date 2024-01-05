export default class DragDrop {
	loadElements(elements, callback) {
		if (elements.length > 0) {
			this.dropZone = elements[0].parentNode;
			this.callback = callback;
		}

		elements.forEach(element => {
			this.addElement(element);
		});
	}

	addElement(element) {
		element.addEventListener('dragstart', (event) => this.dragStart(event.target));
		element.addEventListener('dragover', (event) => this.dragOver(event.target));
		element.addEventListener('dragend', (event) => this.dropped(event.target));
	}

	dragStart(element) {
		this.draggedElement = element;
	}

	dragOver(element) {
		if (this.draggedElement == null || element == this.draggedElement) {
			return;
		}
		
		let current = this.getPosition(element);
		let dragged = this.getPosition(this.draggedElement);

		if (current == null || dragged == null) {
			return;
		}
		
		if (current < dragged) {
			element.before(this.draggedElement);
		} else {
			element.after(this.draggedElement);
		}
	}

	getPosition(element) {
		let position = null;

		for (let index = 0; index < this.dropZone.children.length; index++) {
			if (this.dropZone.children[index] == element) {
				position = index;
			}
		}

		return position;
	}

	dropped(element) {
		this.dragedElement = null;
		this.callback(element, this.getPosition(element));
	}
}
//# sourceMappingURL=dragdrop.js.map
