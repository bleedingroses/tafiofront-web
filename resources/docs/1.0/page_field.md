# Page fields

---

# type
pilihan tipe2 form input field

####color
####date
####email
####number
####password
####select
####select_kas
pilihan rekening kas
####select options
select, bukan dari db, tp dari list yg diisikan. isiannya adalah array spt ini;
`["","color","date","email","number"]`
####static
####text
####textarea

---


# field options
option2 tambahan

####button
tombol, isiannya utk menentukan warna tombol yaitu:
 `success,warning,danger,info,primary,secondary,light,dark`


---



####display_title
nemampilkan nama/judul field


---

####link
contoh isian: `main/{main_id}/halaman/{id}/detail`

> {danger}maksimal cmn 3 level

 kalo lebih dari 3, level ke 4 dst harus bikin getter di model yg bersangkutan

contoh: `main/{main_id}/halaman/{halaman_id}/detail/{id}/sub_detail` maka yg `{main_id}` harus bikin getter di model detail. ini karena field main_id tidak ada di table detail, jd harus ditambahkan getternya


---

####default

default value pas create data
> {danger} yg dibikin baru type multiple_select, isiannya berupa array, dan switch berupa angka 1


---

####parent

####popup

####select

####select_option


####multiple_select

####multiple_select_options

####cannotedit

####display

####format

####ifEmpty
