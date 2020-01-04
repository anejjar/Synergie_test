<template>
    <div class="card"> 
        <div class="card-body">
            <form>
                <div class="form-group">
                    <label >Donnez une note générale</label>
                   <div class="star-rating">
                        <label class="star-rating__star" v-for="(rating, index) in ratings" :key="index"  
                        v-on:click="set(rating)" v-on:mouseover="star_over(rating)" v-on:mouseout="star_out">
                        <input class="star-rating star-rating__checkbox" type="radio" :value="rating" :name="name" 
                        v-model="value" :disabled="disabled"><span  :class="{'is-selected': ((value >= rating) && value != null), 'is-disabled': disabled ,'fa fa-star-o': 1==1} " data-rating="1"></span></label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="avis">Donnez votre avis</label>
                    <textarea class="form-control" v-on:keyup="avisValidate" id="avis" rows="3" v-model="avis"></textarea>
                    <small  v-if="errors.avis"  class="form-text  text-danger">{{errors.avis[0]}}</small>
                </div>
                <div class="form-group">
                    <label for="Titre">Titre de votre avis</label>
                    <input type='text' class="form-control" v-on:blur="titleValidate" id="Titre" v-model="title" placeholder="Ajoutez un titre à votre avis">
                    <small  v-if="errors.title"  class="form-text  text-danger">{{errors.title[0]}}</small>
                </div>
                <div class="form-group">
                    <label for="Titre">Date de votre expérience</label><span class="text-muted">(en option)</span>
                    <h6 class="text-muted">avec une duree (vacances,travaux):<a href='#' > ajouter une date de fin</a></h6>
                    <input type='date' class="form-control" id="date" v-model="date">
                </div>
                <div class="form-group">
                    <a href='#' >Mettre votre numero de commande</a> <span class="text-muted">(en option)</span>
                </div>
                <div class="form-group">
                    <p class="text-muted">En cliquant sur Publiez, je reconnais avoir lu et j'accepte <a href='#' >les Conditions d'utilisation</a></p>
                </div>
                <div class="form-group form-inline">
                    <label class="form-check-label" for="exampleCheck1">Public</label>
                    <input type="checkbox" v-model="isPublic" class="form-check-input" id="exampleCheck1">
                    <button type="submit" class="btn btn-primary pull-right" :class="[disablePost  ? 'disabled' :'']" @click.prevent="publier">Publiez votre message</button>
                </div>
                
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                // rate:star-rating.value,
                avis:'',
                title:'',
                date:'',
                isPublic:false,
                disablePost: false,
                errors:{},
                // star rating
                temp_value: null,
                ratings: [1, 2, 3, 4, 5],
                name: '',
                value:4,
                id: '',
                disabled: false,
                required: false
            }
        },
        watch:{
            errors(){
                if(Object.keys(errors).length){
                    console.log('ddd')
                }else{
                     console.log('ddd')
                }
            }
        },
        methods:{
            //star rating methods 
            star_over: function(index) {
                var self = this;
                // console.log(!this.disabled);
                if (!this.disabled) {
                    this.temp_value = this.value;
                    return this.value = index;
                }

            },
            star_out: function() {
                var self = this;

                if (!this.disabled) {
                    return this.value = this.temp_value;
                }
            },
            set: function(value) {
                var self = this;

                if (!this.disabled) {
                    this.temp_value = value;
                    return this.value = value;
                }
            },


            avisValidate:function(){
                if(this.avis.length < 10 || this.avis.length > 10000){
                    this.errors.avis =["The input value must be between 10-10000 characters"]
                }else{
                    this.errors.avis =''
                }
            },
            titleValidate:function(){
                if(this.title === ''){
                    this.errors.title = ['This field is required']
                }else{
                    this.errors.title =''
                }
            },
            publier:function(){
                if(this.title === ''){
                    this.disablePost = true
                    return ;
                }
                axios
                    .post('/test',{
                        avis:''+ this.avis,
                        title:''+ this.title,
                        date:''+ this.date,
                        stars: this.value,
                        isPublic: this.isPublic,
                    })
                    .then(response => {
                        
                         this.avis=''
                         this.title=''
                         this.date=''
                         this.isPublic=false
                         alert('Data Stored')
                    })
                    .catch(error => {
                        if(error.response.status == 422){
                            this.errors = error.response.data.errors
                        }
                    })
            }
        }
    }

    // var $star_rating = $('.star-rating .fa');

    // var SetRatingStar = function() {
    //     return $star_rating.each(function() {
    //         if (parseInt($star_rating.siblings('input.rating-value').val()) >= parseInt($(this).data('rating'))) {
    //             return $(this).removeClass('fa-star-o').addClass('fa-star');
    //         } else {
    //             return $(this).removeClass('fa-star').addClass('fa-star-o');
    //         }
    //     });
    // };
    // $star_rating.on('mouseover', function() {
    //     $star_rating.siblings('input.rating-value').val($(this).data('rating'));
    //     return SetRatingStar();
    // });
    // SetRatingStar();
</script>
<style scoped>
.star-rating .star-rating__star {
    display: inline-block;
    padding: 3px;
    vertical-align: middle;
    line-height: 1;
    font-size: 1.5em;
    color: #ABABAB;
    transition: color .2s ease-out;
}
 .star-rating__star:hover {
    cursor: pointer;
}
.is-selected {
    color: #FFD700;
}
.star-rating__star .is-disabled:hover {
      cursor: default;
}
.star-rating .star-rating__checkbox{
    position: absolute;
  overflow: hidden;
  clip: rect(0 0 0 0);
  height: 1px; width: 1px;
  margin: -1px; padding: 0; border: 0;
}
</style>