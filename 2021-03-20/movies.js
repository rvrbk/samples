// The assignment was to calculate the average and highest rating for all movies.

let pages = [{
    "data": [{
        "title": "Movie 1",
        "rating": 5.2
    }, {
        "title": "Movie 2",
        "rating": 2.2
    }]
}, {
    "data": [{
        "title": "Movie 3",
        "rating": 6.2
    }, {
        "title": "Movie 4",
        "rating": 3.8
    }]
}];

let moviecount = 0;
let rating_sum = 0;
let max_rating = 0;
let average_rating = 0;

// Loop through the movies and determine the highest and average ratings
pages.forEach((page) => {
	page.data.forEach((movie) => {
        if(movie.rating > max_rating) {
            max_rating = movie.rating;
        }
        
        rating_sum += movie.rating;
        moviecount++;
  });
});

average_rating = (rating_sum / moviecount);

console.log(average_rating, max_rating);