import './comment.scss'
class Comments {
    render(comments) {
        this.fetchComments()
        const liItems = comments.map(comment => {
            return `
                <div>
                    <h1>${comment.title}</h1>
                    <p>${comment.description}</p>
                    <p>${comment.notation}</p>                     
                  </div>
            `
        })

        const div = document.createElement('div');
        div.innerHTML = liItems.join('')
        div.classList.add('articles-grid')
        document.querySelector('body').appendChild(div)
    }

    fetchComments() {
        fetch('http://localhost:8182/api/v1.0/comments', {
            method: 'GET',
            mode: 'no-cors',
            headers: {
                'X-AUTH-TOKEN': 'authKey',
            }
        })
            .then((response) => response.json())
            .then((data) => {
                console.log('Success:', data);
            })
            .catch((error) => {
                console.log('Error:', error);
            });
    }
}

export default Comments;