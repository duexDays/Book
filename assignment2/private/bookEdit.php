<div class="form-popup" id="myBookForm">
    <form action="bookSave.php" class="form-container" id = "bookForm" method="POST">
        <input type="hidden" id="btitle" name="btitle">
        <input type="hidden" id="pISBN" name="pISBN">
        <input type="hidden" id="delete" name="delete" value="">
        <section class="title" id="stitle" name="stitle">
            <span id="ptitle"></span>
        </section>
        <section class="save-contents">
            <section class="option-button-container">
                <button type="button" id="complete" name="complete" class="active"
                    onclick="changeWantType('complete')">Completed</button>
                <div id="buttonReading">
                    <button type="button" id="reading" name="reading" class=""
                        onclick="changeWantType('reading')">Reading</button>
                </div>
                <div id="buttonWant">
                    <button type="button" id="want" name="want" class="" onclick="changeWantType('want')">Want</button>
                </div>
                <input type="hidden" id="wantType" name="wantType" value="<?php echo $pwantType ?>">
            </section>
            <section class="selected-display">
                <p id="readingDate">Reading Date</p>
                <div class="option-container"><span>Start Date</span><input type="date" id="startDate" name="startDate">
                </div>
                <div class="option-container"><span>End Date</span><input type="date" id="endDate" name="endDate"></div>
                <p id="bookReview">Review</p>
                <div class="option-container"><textarea id="review" name="review" rows="5" cols="40"></textarea>
                </div>
                <div class="star-layout">
                    <div class="star-rating space-x-4 mx-auto">
                        <input type="radio" id="5-stars" name="rating" value="5" v-model="ratings" />
                        <label for="5-stars" class="star pr-4">★</label>
                        <input type="radio" id="4-stars" name="rating" value="4" v-model="ratings" />
                        <label for="4-stars" class="star">★</label>
                        <input type="radio" id="3-stars" name="rating" value="3" v-model="ratings" />
                        <label for="3-stars" class="star">★</label>
                        <input type="radio" id="2-stars" name="rating" value="2" v-model="ratings" />
                        <label for="2-stars" class="star">★</label>
                        <input type="radio" id="1-star" name="rating" value="1" v-model="ratings" />
                        <label for="1-star" class="star">★</label>
                    </div>
                </div>
            </section>
        </section>

        <button type="submit" class="btn">Save</button>
        <button type="button" class="cancel" onclick="closeForm()">Close</button>
        <button type="button" class="delete" onclick="deleteBook()">Delete</button>
    </form>
</div>