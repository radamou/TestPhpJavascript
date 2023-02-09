import './article.scss'

class Articles {
    render(articles) {
        const liItems = articles.map(article => {
            return `
                <div>
                    <h1>${article.title}</h1>
                    <p>${article.content}</p>                   
                  </div>
            `
        })

        const div = document.createElement('div');
        div.innerHTML = liItems.join('')
        div.classList.add('articles-grid')
        document.querySelector('body').appendChild(div)
    }
}

export default Articles;