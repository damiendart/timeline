class Dropdown {
  constructor(containerElement) {
    this.buttonElement = document.createElement('button');
    this.containerElement = containerElement;
    this.eventListeners = {
      // eslint-disable-next-line no-underscore-dangle
      click: [this._onClick.bind(this)],
      // eslint-disable-next-line no-underscore-dangle
      focusout: [this._onFocusOut.bind(this)],
      // eslint-disable-next-line no-underscore-dangle
      keydown: [this._onKeyDown.bind(this)],
    };
    this.headingElement = this.containerElement.querySelector('.dropdown__heading');
    this.menuElement = this.containerElement.querySelector('.dropdown__menu');
    this.menuID = `menu-${this.headingElement
      .textContent
      .replace(/\s+/, '-')
      .toLowerCase()}`;

    // eslint-disable-next-line no-underscore-dangle
    this._updateElements();
    // eslint-disable-next-line no-underscore-dangle
    this._addEventListeners();
  }

  closeMenu() {
    this.buttonElement.setAttribute('aria-expanded', 'false');
    this.menuElement.setAttribute('aria-hidden', 'true');
  }

  destroy() {
    Object.keys(this.eventListeners).forEach(
      (event) => {
        this.eventListeners[event].forEach((item) => {
          this.containerElement.removeEventListener(event, item);
        });
      },
    );

    this.menuElement.removeAttribute('aria-hidden');
    this.menuElement.removeAttribute('id');
    this.containerElement.removeAttribute('tabindex');
    this.containerElement.replaceChild(this.headingElement, this.buttonElement);
  }

  isMenuOpen() {
    return (this.menuElement.getAttribute('aria-hidden') === 'false');
  }

  openMenu() {
    this.buttonElement.setAttribute('aria-expanded', 'true');
    this.menuElement.setAttribute('aria-hidden', 'false');
  }

  // eslint-disable-next-line no-underscore-dangle
  _addEventListeners() {
    Object.keys(this.eventListeners).forEach(
      (event) => {
        this.eventListeners[event].forEach((item) => {
          this.containerElement.addEventListener(event, item);
        });
      },
    );
  }

  // eslint-disable-next-line no-underscore-dangle
  _onClick(event) {
    if (this.buttonElement.contains(event.target) === false) {
      return;
    }

    event.preventDefault();

    if (this.isMenuOpen()) {
      this.closeMenu();
    } else {
      this.openMenu();
    }
  }

  // eslint-disable-next-line no-underscore-dangle
  _onFocusOut(event) {
    if (this.containerElement.contains(event.relatedTarget)) {
      return;
    }

    this.closeMenu();
  }

  // eslint-disable-next-line no-underscore-dangle
  _onKeyDown(event) {
    // Based on <https://twitter.com/heydonworks/status/880773131287359488>.
    const focusableElementSelector = '[href], input[type="submit"], button';

    if (event.key === 'ArrowDown') {
      event.preventDefault();

      if (this.buttonElement.contains(event.target)) {
        if (this.isMenuOpen()) {
          this.menuElement.querySelector(focusableElementSelector).focus();
        } else {
          this.openMenu();
        }
      } else if (this.menuElement.contains(event.target)) {
        if (this.menuElement.lastElementChild.contains(event.target)) {
          this
            .menuElement
            .firstElementChild
            .querySelector(focusableElementSelector)
            .focus();
        } else {
          event
            .target
            .closest('.dropdown__menu__item')
            .nextElementSibling
            .querySelector(focusableElementSelector)
            .focus();
        }
      }
    } else if (
      event.key === 'ArrowUp'
      && this.menuElement.contains(event.target)
    ) {
      event.preventDefault();

      if (this.menuElement.firstElementChild.contains(event.target)) {
        this
          .menuElement
          .lastElementChild
          .querySelector(focusableElementSelector)
          .focus();
      } else {
        event
          .target
          .closest('.dropdown__menu__item')
          .previousElementSibling
          .querySelector(focusableElementSelector)
          .focus();
      }
    } else if (event.key === 'Escape') {
      event.preventDefault();
      this.closeMenu();
      this.buttonElement.focus();
    }
  }

  // eslint-disable-next-line no-underscore-dangle
  _updateElements() {
    this.buttonElement.innerHTML = this.headingElement.innerHTML.trim();

    [...this.headingElement.attributes].forEach(
      (attribute) => this.buttonElement.setAttribute(
        attribute.nodeName,
        attribute.nodeValue,
      ),
    );

    this.buttonElement.setAttribute('aria-controls', this.menuID);
    this.buttonElement.setAttribute('aria-expanded', 'false');
    this.buttonElement.setAttribute('aria-haspopup', 'true');
    this.menuElement.setAttribute('aria-hidden', 'true');
    this.menuElement.setAttribute('id', this.menuID);

    // For more information on transforming elements into buttons, see
    // <https://justmarkup.com/articles/2019-01-21-the-link-to-button-enhancement/>.
    this.containerElement.replaceChild(this.buttonElement, this.headingElement);
    // Setting the "tabindex" attribute of the container element to "-1"
    // allows users to click non-focusable areas of the dropdown menu
    // without triggering the "focusout" event handler (thus closing the
    // menu). For more information, please see
    // <https://webaim.org/techniques/keyboard/tabindex#zero-negative-one>.
    this.containerElement.setAttribute('tabindex', '-1');
  }
}

export default Dropdown;
