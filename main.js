import React, { Component } from 'react';
import ReactDOM from 'react-dom';

class App extends Component {
  state = { recipes: [], recipeId: 0 }

  componentWillMount() {
    fetch('https://api.kstiopin.in.ua/get_cooking_data.php', {
      method: 'GET',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
      }
    }).then(resp => resp.json()).then(recipes => {
      this.setState({ recipes });
    });
  }

  setRecipe = (recipeId) => this.setState({ recipeId })

  render() {
    const { recipes, recipeId } = this.state;
    const cousine = recipes.find(recipe => recipe.id === recipeId);
    console.log('RENDER', this.state);

    return (<div className='main'>
      <div className='menu'>
        { recipes.map(recipe => <div key={ recipe.id }>
          <h3 className={ (recipe.id === recipeId) ? 'active' : '' } onClick={ () => this.setRecipe(recipe.id) }>{ recipe.name }</h3>
        </div>) }
      </div>
      { cousine && <div className='recipe'>
        <h2>Ингридиенты:</h2>
        <ul>
          { cousine.ingredients.map(ingredient => <li key={ ingredient.id }>
            { ingredient.name }
            { !!ingredient.amount && <span>:&nbsp;{ ingredient.amount }</span> }
          </li>) }
        </ul>
        <h2>Рецепт:</h2>
        <p>{ cousine.recipe }</p>
        { (cousine.photos.length > 0) && <h2>Фото:</h2> }
        { (cousine.photos.length > 0) && <div className='photos'>
          { cousine.photos.map(photo => <img key={ photo } src={ `./photos/${photo}` } alt={ cousine.name } />) }
        </div> }
      </div> }
    </div>);
  }
}

ReactDOM.render(<App />, document.getElementById('app'));