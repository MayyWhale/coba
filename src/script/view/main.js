import dashboard from "./dashboard.js";
import jurusan from "./master/jurusan.js";
import perhitungan from "./perhitungan.js";
import kriteria from "./master/kriteria.js";
import user from "./master/user.js";

const main = () => {
  const utils = {
    myModal: {
      modal: new bootstrap.Modal("#myModal"),
      title: $("#myModal .modal-title"),
      body: $("#myModal .modal-body"),
    },
  };
  $(".preloader").fadeOut();
  switch (page) {
    case "dashboard":
      dashboard(utils);
      break;
    case "master-jurusan":
      jurusan(utils);
      break;
    case "master-kriteria":
      kriteria(utils);
      break;
    case "perhitungan":
      perhitungan(utils);
      break;
    case "user":
      user(utils);
      break;
    default:
      break;
  }
};

export default main;
