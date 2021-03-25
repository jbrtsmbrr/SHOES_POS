$(".lookup").on("click", function(e) {
  let lookuptype = $(this).attr('lookuptype');

  fetch(`${moduleid}/lookup/${lookuptype}`)
  .then(function (response) {
    // The API call was successful!
    return response.json();
  }).then(function (res) {
    // This is the HTML from our response as a text string
    // $("#lookup-list").html(res);
    // console.log(res.modal_setup.header);
    let tbl_header = res.modal_setup.header;
    let tbl_content = res.modal_setup.body;
    let title = res.modal_setup.title;

    $("#lookup-title").text(title);
    let tbl_head = "";
    let tbl_body = "";

    tbl_head += "<tr>";
    for(let i=0; i<tbl_header.length; i++) {
      tbl_head += `
        <th>${tbl_header[i]}</th>
      `;
    }
    tbl_head += "<tr>";
    $("#tbl_head").html(tbl_head);
    
    for (let i=0; i<tbl_content.length; i++) {
      tbl_body += "<tr>";
      for (var j in tbl_content[i]) {
        if (tbl_content[i].hasOwnProperty(j)) {
          tbl_body += `<td>${tbl_content[i][j]}</td>`;
        }
      }
      tbl_body += "</tr>";
      // console.log(Object.keys(tbl_content[i]));
    }
    $("#tbl_body").html(tbl_body);
  });
});