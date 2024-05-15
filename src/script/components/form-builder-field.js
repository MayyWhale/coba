class FormBuilderField extends HTMLElement {
  constructor() {
    super();
  }

  set field(field) {
    this._field = field;
    this._field.prefix = field.prefix ?? "Masukkan";
    switch (field.type) {
      case "text":
        this.genericRenderer();
        break;
      case "email":
        this.genericRenderer();
        break;
      case "password":
        this.genericRenderer();
        break;
      case "select":
        this.selectRenderer();
        break;
      default:
        throw `Type ${field.type} is not Supported`;
        break;
    }
  }

  genericRenderer() {
    this.innerHTML = `
    <div class="form-group">
        <label for="${this._field.name}">${
      this._field.label ?? this._field.name
    }</label>
        <input type="${this._field.type}" class="form-control" id="${
      this._field.id ?? this._field.name
    }" name="${
      this._field.name
    }" placeholder="${this.placeholderGenerator()}" required>
    </div>
    `;
  }

  selectRenderer() {
    this.innerHTML = `
    <div class="form-group">
        <label for="${this._field.name}">${
      this._field.label ?? this._field.name
    }</label>
        <select class="form-control" id="${
          this._field.id ?? this._field.name
        }" name="${this._field.name}" required>
          <option value="">Pilih ${
            this._field.label ?? this._field.name
          }</option>
          ${this._field.options
            .map(
              (option) => `
            <option value="${option.value}">${option.text}</option>
          `
            )
            .join("")}
        </select>
    </div>
    `;
  }

  placeholderGenerator() {
    let output =
      this._field.placeholder ??
      this._field.prefix + " " + (this._field.label ?? this._field.name);
    return output;
  }
}

customElements.define("form-builder-field", FormBuilderField);
