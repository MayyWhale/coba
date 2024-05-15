import "../components/multiple-field.js";
class ModalInput extends HTMLElement {
  constructor() {
    super();
  }

  set field(field) {
    this._field = field;
    this._field.prefix = field.prefix ?? "Masukkan";
    switch (field.type) {
      case "hidden":
        this.hiddenRenderer();
        break;
      case "text":
        this.genericRenderer();
        break;
      case "email":
        this.genericRenderer();
        break;
      case "select":
        this.selectRenderer();
        break;
      case "password":
        this.genericRenderer();
        break;
      case "multiselect":
        this.multiselectRenderer();
        break;
      case "multiple-field":
        this.multiFieldRenderer();
        break;

      default:
        throw `Type ${field.type} is not Supported`;
        break;
    }
  }

  hiddenRenderer() {
    this.innerHTML = `
    <input type="${this._field.type}" name="${this._field.name}" value="${this._field.value ?? ""}">
      `;
  }

  genericRenderer() {
    this.innerHTML = `
      <div class="form-group">
          <label for="${this._field.name}">${this._field.label ?? this._field.name}</label>
          <input type="${this._field.type}" class="form-control" id="${this._field.id ?? this._field.name}" name="${this._field.name}" placeholder="${this.placeholderGenerator()}" ${this._field.required ? "required " : ""}value="${
      this._field.value ?? ""
    }">
      </div>
      `;
  }

  selectRenderer() {
    this.innerHTML = `
      <div class="form-group">
          <label for="${this._field.name}">${this._field.label ?? this._field.name}</label>
          <select class="form-control" id="${this._field.id ?? this._field.name}" name="${this._field.name}" ${this._field.required ? "required " : ""}>
            <option value="">Pilih ${this._field.label ?? this._field.name}</option>
            ${this._field.options.map((option) => `<option value="${option.value}" ${option.value == this._field.value ? "selected" : ""}>${option.text}</option>`).join("")}
          </select>
      </div>
      `;
  }

  multiselectRenderer() {
    this.innerHTML = `
      <div class="form-group">
          <label for="${this._field.name}">${this._field.label ?? this._field.name}</label>
          <select class="form-control multiselect-init" name="${this._field.name}[]" multiple="multiple" ${this._field.required ? "required " : ""}>
          </select>
      </div>
      `;
  }

  multiFieldRenderer() {
    const el = document.createElement("multiple-field");
    el.attr = this._field;
    this.append(el);
  }

  placeholderGenerator() {
    let output = this._field.placeholder ?? this._field.prefix + " " + (this._field.label ?? this._field.name);
    return output;
  }
}

customElements.define("modal-input", ModalInput);
