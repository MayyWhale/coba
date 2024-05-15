class ComparisonRange extends HTMLElement {
  constructor() {
    super();
  }

  set features(features) {
    this._features = features;
    this.render();
  }

  attributeChangedCallback(name, oldValue, newValue) {}

  static get observedAttributes() {
    return [];
  }

  render() {
    this.innerHTML = `
    <div class="form-group">
        <div class="row">
          <div class="col-md-4 text-start">
          <span><small>${this._features.ltitle ?? "Left"}</small></span>
          </div>
          <div class="col-md-4 text-center">
          <span class="w-30 badge text-bg-primary message">sama penting</span>
          </div>
          <div class="col-md-4 text-end">
          <span><small>${this._features.rtitle ?? "Right"}</small></span>
          </div>
        </div>
        <input type="range" class="form-range" min="-${this._features.interval ?? 4}" max="${this._features.interval ?? 4}" id="${this._features.name ?? "range"}" name="${this._features.name ?? "range"}" id="${
      this._features.name ?? "range"
    }">
    </div>
      `;
    this.querySelector("input").addEventListener("change", (e) => {
      this.querySelector(".message").innerText = e.target.value == 0 ? `Sama Penting` : e.target.value > 0 ? `${Math.abs(e.target.value) + 1} kali Lebih Penting Dari` : `${Math.abs(e.target.value) + 1} kali Tidak Lebih Penting Dari`;
    });
  }
}

customElements.define("comparison-range", ComparisonRange);
