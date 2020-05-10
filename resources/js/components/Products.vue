<template>
    <div class="container">
        <div class="row shadow-sm mb-3 mt-3 pb-2 pt-2">
            <div class="col">
                Name
            </div>
            <div class="col">
                In stock
            </div>
            <div class="col">
                Price per unit
            </div>
            <div class="col">
                Edit
            </div>
            <div class="col">
                More
            </div>
            <div class="col">
                Delete
            </div>
            <div class="col-1">
                <button class="btn btn-link" data-toggle="modal" data-target="#newProductModal" v-on:click="(e)=>showAddProductModal(e)"><font-awesome-icon :id="'new-button'" :icon="['fas','plus']"></font-awesome-icon></button>
            </div>
        </div>
        <div v-for="(product) in products">
            <div class="row shadow-sm mb-2 mt-0">
                <div class="col">
                    {{product.name}}
                </div>
                <div class="col">
                    {{product.stock}}
                </div>
                <div class="col">
                    {{product.price}}
                </div>
                <div class="col">
                    <button data-toggle="modal" data-target="#editProductModal" v-on:click="(e)=>showEditProductModal(product.id,e)"  type="button" class="btn btn-link"><font-awesome-icon :id="'fa-edit-'+product.id" :icon="['fas','edit']"></font-awesome-icon></button>
                </div>
                <div class="col">
                    <button v-on:click="(e)=>toggleCollapse(product.id,e)"  type="button" class="btn btn-link"><font-awesome-icon :id="'fa'+product.id" :icon="['fas','caret-down']"></font-awesome-icon></button>
                </div>
                <div class="col-sm center-text">
                    <button class="btn btn-link text-danger-on-hover" v-on:click="(e)=>remove(product.id,e)"><font-awesome-icon :icon="['fas','trash']"></font-awesome-icon></button>
                </div>
                <div class="col-1">
                    <p></p>
                </div>
            </div>
            <div class="collapse row shadow-sm" :id="'coll'+product.id">
                    <img :src="product.image_path"  class="col-6" style="max-width: 317px" alt="Image not found, contact administrator">
                    <div class="col-6">
                        <p>{{product.description}}</p>
                    </div>
            </div>
        </div>

        <div class="modal fade bd-example-modal-lg" id="editProductModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content justify-content-center">
                    <form class="form-horizontal">
                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="editName">Name</label>
                            <div class="col-md-4">
                                <input id="editName" name="name" v-model="editedProduct.name" type="text" placeholder="" class="form-control input-md">

                            </div>
                        </div>

                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="editPrice">Price</label>
                            <div class="col-md-4">
                                <input id="editPrice" name="price" v-model="editedProduct.price" type="text" placeholder="" class="form-control input-md">

                            </div>
                        </div>

                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="editStock">Stock</label>
                            <div class="col-md-4">
                                <input id="editStock" name="stock" v-model="editedProduct.stock" type="text" placeholder="" class="form-control input-md">

                            </div>
                        </div>

                        <!-- Select Basic -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="editCategory">Category</label>
                            <div class="col-md-4">
                                <select id="editCategory" name="category" v-model="editedProduct.category_id" class="form-control">
                                    <option v-for="(category) in categories" :value="category.id">{{category.name}}</option>
                                </select>
                            </div>
                        </div>

                        <!-- Textarea -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="editDescription">Description</label>
                            <div class="col-md-4">
                                <textarea class="form-control" id="editDescription" v-model="editedProduct.description" name="description"></textarea>
                            </div>
                        </div>

                        <!-- File Button -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="editImage">Image</label>
                            <div class="col-md-4">
                                <input id="editImage" name="image" class="input-file" type="file">
                            </div>
                            <button class="btn btn-outline-primary" v-on:click="(e)=>uploadFile('#editImage',e)">Upload</button>
                        </div>

                        <!-- Button -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="saveEdit"></label>
                            <div class="col-md-4">
                                <button id="saveEdit" name="saveEdit" v-on:click="(e)=>saveEditedProduct(e)" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade bd-example-modal-lg" id="newProductModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content justify-content-center">
                    <form class="form-horizontal">
                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="newName">Name</label>
                            <div class="col-md-4">
                                <input id="newName" name="name" v-model="newProduct.name" type="text" placeholder="" class="form-control input-md">

                            </div>
                        </div>

                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="newPrice">Price</label>
                            <div class="col-md-4">
                                <input id="newPrice" name="price" v-model="newProduct.price" type="number" placeholder="" class="form-control input-md">

                            </div>
                        </div>

                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="newStock">Stock</label>
                            <div class="col-md-4">
                                <input id="newStock" name="stock" v-model="newProduct.stock" type="number" placeholder="" class="form-control input-md">

                            </div>
                        </div>

                        <!-- Select Basic -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="newCategory">Category</label>
                            <div class="col-md-4">
                                <select id="newCategory" name="category" v-model="newProduct.category_id" class="form-control">
                                    <option v-for="(category) in categories" :value="category.id">{{category.name}}</option>
                                </select>
                            </div>
                        </div>

                        <!-- Textarea -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="newDescription">Description</label>
                            <div class="col-md-4">
                                <textarea class="form-control" id="newDescription" v-model="newProduct.description" name="description"></textarea>
                            </div>
                        </div>

                        <!-- File Button -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="newImage">Image</label>
                            <div class="col-md-4">
                                <input id="newImage" name="image" class="input-file" type="file">
                            </div>
                            <button class="btn btn-outline-primary" v-on:click="(e)=>uploadFile('#newImage',e)">Upload</button>
                        </div>

                        <!-- Button -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="addNew"></label>
                            <div class="col-md-4">
                                <button id="addNew" v-on:click="(e)=>saveNewProduct(e)" name="addNew" class="btn btn-primary">Add</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        name: "Products",
        data()
        {
            return {
                products: [],
                categories: [],
                newProduct: {name:'',price:0.00,stock:0,description:'',image_path:'',category_id:0},
                editedProduct:{}
            }
        },
        mounted()
        {
            axios.get('/api/products',).then((response)=>
            {
                this.products=response.data;
            }).catch(error => {
                console.error(error);
            });
            axios.get('/api/categories',).then((response)=>
            {
                this.categories=response.data;
            }).catch(error => {
                console.error(error);
            });
        },
        methods:
            {
                animateRotation(id)
                {
                    $('#fa'+id).toggleClass('fa-rotate-180');
                },
                toggleCollapse(id,e)
                {
                    e.preventDefault();
                    this.animateRotation(id);
                    $('#coll'+id).collapse('toggle');
                },
                showAddProductModal(e)
                {
                    // nothing??
                },
                showEditProductModal(id,e)
                {
                    e.preventDefault();
                    this.products.forEach((product)=>{
                       if(product.id===id)
                       {
                           this.editedProduct=product;
                       }
                    });
                    $('#editModal').modal('show');
                },
                saveEditedProduct(e)
                {
                    e.preventDefault();
                    axios.patch('/api/products/'+this.editedProduct.id, this.editedProduct)
                        .then(response => {
                            this.refresh();
                        })
                        .catch(error => {
                            console.error(error);
                        });
                    $('#editModal').modal('hide');
                },
                saveNewProduct(e)
                {
                    e.preventDefault();
                    axios.post('/api/products/', this.newProduct)
                    .then(response => {
                        this.refresh();
                    })
                    .catch(error => {
                        console.error(error);
                    });
                    $('#addNewModal').modal('hide');
                },
                remove(id,e)
                {
                    e.preventDefault();
                    axios.delete('/api/products/'+id).then((response)=>
                        this.refresh();
                    ).catch(error => {
                        console.error(error);
                    });
                },
                uploadFile(fieldId, e)
                {
                    e.preventDefault();
                    let img = $(fieldId).prop('files')[0];
                    let formData = new FormData();
                    formData.append("image", img);
                    let headers = {'Content-Type': 'multipart/form-data'};
                    axios.post('/api/upload-file',formData,{headers}).then(response => {
                        let x = response.data.search('/images');
                        this.newProduct.image_path = response.data.substring(x);
                    })
                },
                refresh(){
                    axios.get('/api/products',).then((response)=>
                    {
                        this.products=response.data;
                    }).catch(error => {
                        console.error(error);
                    });
                    axios.get('/api/categories',).then((response)=>
                    {
                        this.categories=response.data;
                    }).catch(error => {
                        console.error(error);
                    });
                }
            }
    }
</script>

<style scoped>
    .center-text {
        display: inline-flex;
        align-items: center !important;
        align-content: center !important;
    }
    .text-danger-on-hover:hover
    {
        color:#e3342f;
    }
    .text-danger-on-hover
    {
        color:#6c757d;
    }

</style>
