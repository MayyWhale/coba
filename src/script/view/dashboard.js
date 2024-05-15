import "select2";
import "../utils/loader-spinner.js";
import "../components/form-builder.js";
import DataSource from "../data/data-source.js";

const dashboard = (utils) => {
  console.log(`init ${page} page.....`);
  const pilihJurusanButton = $("#pilihJurusanButton");

  const onPilihJurusanModalButtonClicked = async () => {
    utils.myModal.title.text("Pilih Jurusan");
    utils.myModal.body.html(`<loader-spinner></loader-spinner>`);
    utils.myModal.modal.toggle();
    try {
      const result = await DataSource.formPilihJurusan();
      utils.myModal.body.html(`<form-builder></form-builder>`);
      console.log(result);
      renderResult(result);
      $("select").select2({
        placeholder: "Pilih Jurusan yang anda minati",
        data: result.fields[0].options,
      });
    } catch (message) {
      utils.myModal.body.html(`<form-builder></form-builder>`);
      fallbackResult(message);
    }
  };

  const onCalcAlternate = async () => {
    utils.myModal.title.text("Input Nilai Alternatif");
    utils.myModal.body.html(`<loader-spinner></loader-spinner>`);
    utils.myModal.modal.toggle();
    try {
      const result = await DataSource.formAlternatif(utils.myModal.id);
      utils.myModal.body.html(`<form-builder></form-builder>`);
      console.log(result);
      renderResult(result);
    } catch (message) {
      utils.myModal.body.html(`<form-builder></form-builder>`);
      fallbackResult(message);
    }
  };

  const renderResult = (results) => {
    const formBuilderEl = document.querySelector("form-builder");
    formBuilderEl.mode = results.mode ?? "normal";
    formBuilderEl.fields = results.fields ?? [];
    formBuilderEl.hrefurl = results.url ?? "";
  };

  const fallbackResult = (message) => {
    const formBuilderEl = document.querySelector("form-builder");
    formBuilderEl.renderError(message);
  };

  pilihJurusanButton.on("click", onPilihJurusanModalButtonClicked);
  $("body").on("click", ".calc-button", (event) => {
    utils.myModal.id = event.currentTarget.id;
    console.log(event.currentTarget.id);
    onCalcAlternate();
  });
};

export default dashboard;
