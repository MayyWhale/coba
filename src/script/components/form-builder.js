import "../utils/modal-input.js";
import "./form-builder-field.js";
import "./form-builder-button.js";

class FormBuilder extends HTMLElement {
  constructor() {
    super();
    this.validator = ["type", "name"];
    this._mode = "normal";
  }

  connectedCallback() {
    this.render();
  }

  set mode(mode) {
    this._mode = mode;
  }
  set fields(fields) {
    this._fields = fields;
    try {
      this.validateFields();
      this.updateFields();
    } catch (error) {
      this.renderError(error);
    }
  }

  set hrefurl(url) {
    this._hrefurl = url;
    this.updateHrefUrl();
  }

  set formMethod(method) {
    if (method) {
      this._method = method;
      this.updateMethod();
    }
  }

  updateHrefUrl() {
    this.querySelector("form").setAttribute("action", this._hrefurl ?? null);
  }

  updateMethod() {
    this.querySelector("form").setAttribute("method", this._method ?? "POST");
  }

  validateFields() {
    if (this._fields.length > 0) {
      this._fields.forEach((field, i) => {
        this.validator.map((k) => {
          if (!Object.keys(field).includes(k)) throw `field key "${k}" is not includes on index ${i}`;
        });
      });
    } else {
      throw "Field Kosong";
    }
  }

  updateFields() {
    const form = this.querySelector("form");
    let formFieldEl;
    form.innerHTML = "";
    this._fields.forEach((field) => {
      switch (this._mode) {
        case "normal":
          formFieldEl = document.createElement("form-builder-field");
          break;
        case "modal":
          formFieldEl = document.createElement("modal-input");
          break;
        default:
          break;
      }
      formFieldEl.field = field;
      form.appendChild(formFieldEl);
    });
    form.appendChild(document.createElement("form-builder-button"));
  }

  attributeChangedCallback(name, oldValue, newValue) {
    if (name == "hrefurl") {
      this.updateHrefUrl(newValue);
    } else if (name == "method") {
      this.updateHrefUrl(newValue);
    }
  }

  static get observedAttributes() {
    return ["hrefurl", "method"];
  }

  renderError(message) {
    const form = this.querySelector("form");
    form.innerHTML = `
    <style>
      .placeholder {
        font-weight: lighter;
        color: rgba(0,0,0,0.5);
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }
    </style>
  `;
    form.innerHTML += `<h2 class="placeholder">${message}</h2>`;
  }

  render() {
    this.innerHTML = `
      <form class="forms-sample">
      </form>
      `;
    this.updateMethod();
  }
}

customElements.define("form-builder", FormBuilder);
