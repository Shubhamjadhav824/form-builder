let fields = fields || [];

function addField() {
  fields.push({
    label: "",
    type: "text",
    required: false,
    options: []
  });
  renderFields();
}

function renderFields() {
  const container = document.getElementById("fields");
  container.innerHTML = "";

  fields.forEach((field, index) => {
    let optionsHTML = "";

    if (field.type === "dropdown" || field.type === "checkbox") {
      optionsHTML = `
        <input
          type="text"
          placeholder="Options (comma separated)"
          value="${field.options.join(",")}"
          onchange="updateOptions(${index}, this.value)">
      `;
    }

    container.innerHTML += `
      <div class="field-box">
        <label>Field Label</label>
        <input
          type="text"
          value="${field.label}"
          onchange="fields[${index}].label=this.value">

        <label>Field Type</label>
        <select onchange="changeType(${index}, this.value)">
          <option value="text" ${field.type==="text"?"selected":""}>Text</option>
          <option value="number" ${field.type==="number"?"selected":""}>Number</option>
          <option value="dropdown" ${field.type==="dropdown"?"selected":""}>Dropdown</option>
          <option value="checkbox" ${field.type==="checkbox"?"selected":""}>Checkbox</option>
        </select>

        <label>
          <input
            type="checkbox"
            ${field.required?"checked":""}
            onchange="fields[${index}].required=this.checked">
          Required
        </label>

        ${optionsHTML}

        <button type="button" onclick="removeField(${index})">
          Remove Field
        </button>
        <hr>
      </div>
    `;
  });

  document.getElementById("structure").value = JSON.stringify(fields);
}

function updateOptions(index, value) {
  fields[index].options = value.split(",").map(v => v.trim());
  renderFields();
}

function changeType(index, type) {
  fields[index].type = type;
  if (type === "text" || type === "number") {
    fields[index].options = [];
  }
  renderFields();
}

function removeField(index) {
  fields.splice(index, 1);
  renderFields();
}

document.addEventListener("DOMContentLoaded", renderFields);
