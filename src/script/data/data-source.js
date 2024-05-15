class DataSource {
  static async formJurusan(idSend) {
    return fetch(`${baseurl}master/jurusan/form`, {
      method: "POST", // or 'PUT'
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        id: idSend ?? null,
      }),
    })
      .then((response) => response.json())
      .then((data) => {
        return data;
      })
      .catch((error) => {
        return error;
      });
  }

  static async formAlternatif(idSend) {
    return fetch(`${baseurl}hitung/alternatif`, {
      method: "POST", // or 'PUT'
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        id: idSend ?? null,
      }),
    })
      .then((response) => response.json())
      .then((data) => {
        return data;
      })
      .catch((error) => {
        return error;
      });
  }

  static async formPilihJurusan() {
    return fetch(`${baseurl}form-pilih-jurusan`, {
      method: "POST", // or 'PUT'
      headers: {
        "Content-Type": "application/json",
      },
    })
      .then((response) => response.json())
      .then((data) => {
        return data;
      })
      .catch((error) => {
        return error;
      });
  }

  static async pagePerhitungan() {
    return fetch(`${baseurl}hitung/content`, {
      method: "POST", // or 'PUT'
      headers: {
        "Content-Type": "application/json",
      },
    })
      .then((response) => response.json())
      .then((data) => {
        return data;
      })
      .catch((error) => {
        return error.messages;
      });
  }

  static async formKriteria(idSend) {
    return fetch(`${baseurl}master/kriteria/form`, {
      method: "POST", // or 'PUT'
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        id: idSend ?? null,
      }),
    })
      .then((response) => response.json())
      .then((data) => {
        return data;
      })
      .catch((error) => {
        return error.messages;
      });
  }

  static async formUser(idSend) {
    return fetch(`${baseurl}master/user/form`, {
      method: "POST", // or 'PUT'
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        id: idSend ?? null,
      }),
    })
      .then((response) => response.json())
      .then((data) => {
        return data;
      })
      .catch((error) => {
        return error.messages;
      });
  }
}

export default DataSource;
