document.addEventListener("DOMContentLoaded", loadStudents);

function showStudentForm(index = null) {
    let students = JSON.parse(localStorage.getItem("students")) || [];
    let student = index !== null ? students[index] : {};

    Swal.fire({
        title: index === null ? "Agregar Estudiante" : "Editar Estudiante",
        html: `
            <input type="file" id="photo" accept="image/*" onchange="previewPhoto(event)">
            <img id="preview" src="${student.photo || ''}" style="width: 80px; height: 80px; display: ${student.photo ? 'block' : 'none'}; border-radius: 50%; margin-top: 10px;">
            <input type="text" id="name" class="swal2-input" placeholder="Nombre" value="${student.name || ''}">
            <input type="text" id="surname" class="swal2-input" placeholder="Apellido" value="${student.surname || ''}">
            <input type="number" id="age" class="swal2-input" placeholder="Edad" value="${student.age || ''}">
            <input type="email" id="email" class="swal2-input" placeholder="Correo" value="${student.email || ''}">
            <input type="text" id="idCard" class="swal2-input" placeholder="Cédula" value="${student.idCard || ''}">
            <input type="text" id="phone" class="swal2-input" placeholder="Número" value="${student.phone || ''}">
        `,
        showCancelButton: true,
        confirmButtonText: index === null ? "Agregar" : "Guardar",
        preConfirm: () => {
            return new Promise((resolve) => {
                let reader = new FileReader();
                let photoFile = document.getElementById("photo").files[0];

                let newStudent = {
                    photo: student.photo || '',
                    name: document.getElementById("name").value,
                    surname: document.getElementById("surname").value,
                    age: document.getElementById("age").value,
                    email: document.getElementById("email").value,
                    idCard: document.getElementById("idCard").value,
                    phone: document.getElementById("phone").value
                };

                if (photoFile) {
                    reader.onload = function (event) {
                        newStudent.photo = event.target.result;
                        resolve(newStudent);
                    };
                    reader.readAsDataURL(photoFile);
                } else {
                    resolve(newStudent);
                }
            });
        }
    }).then((result) => {
        if (result.isConfirmed) {
            if (index !== null) {
                students[index] = result.value;
            } else {
                students.push(result.value);
            }
            localStorage.setItem("students", JSON.stringify(students));
            loadStudents();
        }
    });
}

function previewPhoto(event) {
    let reader = new FileReader();
    reader.onload = function () {
        let preview = document.getElementById("preview");
        preview.src = reader.result;
        preview.style.display = "block";
    };
    reader.readAsDataURL(event.target.files[0]);
}

function loadStudents() {
    let students = JSON.parse(localStorage.getItem("students")) || [];
    let table = document.getElementById("studentTable");
    table.innerHTML = "";

    students.forEach((student, index) => {
        let row = `
            <tr>
                <td><img src="${student.photo}" alt="Foto"></td>
                <td>${student.name}</td>
                <td>${student.surname}</td>
                <td>${student.age}</td>
                <td>${student.email}</td>
                <td>${student.idCard}</td>
                <td>${student.phone}</td>
                <td class="actions">
                    <button class="edit" onclick="showStudentForm(${index})">✏️</button>
                    <button class="delete" onclick="deleteStudent(${index})">🗑️</button>
                </td>
            </tr>
        `;
        table.innerHTML += row;
    });
}

function deleteStudent(index) {
    Swal.fire({
        title: "¿Seguro?",
        text: "Esto eliminará al estudiante",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            let students = JSON.parse(localStorage.getItem("students"));
            students.splice(index, 1);
            localStorage.setItem("students", JSON.stringify(students));
            loadStudents();
        }
    });
}

function filterStudents() {
    let search = document.getElementById("search").value.toLowerCase();
    document.querySelectorAll("#studentTable tr").forEach(row => {
        row.style.display = row.children[5].textContent.toLowerCase().includes(search) ? "" : "none";
    });
}