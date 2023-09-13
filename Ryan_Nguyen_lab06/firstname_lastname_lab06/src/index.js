import React from 'react';
import ReactDOM from 'react-dom/client';
import './index.css';
import App from './App';
import reportWebVitals from './reportWebVitals';

// const root = ReactDOM.createRoot(document.getElementById('root'));
// root.render(
//   <React.StrictMode>
//     <App />
//   </React.StrictMode>
// );

// Author: Ryan Nguyen
// Student ID: 101127319

const Lab06App = function (props) {
  return(
    <main>
        <Title label="Lab06 - React Application"/>
        <Catalog/>
    </main>
  );
};

const root = ReactDOM.createRoot(document.querySelector('#react-lab'));
root.render(<Lab06App/>);

const Title = function (props) {
  return <h1>{props.label}</h1>
}

class Catalog extends React.Component {
  constructor(props) {
    super(props);
    this.state = {editing: false, filename: "images/img1.jpg", alt: "image 1"};
    this.handleNameChange = this.handleNameChange.bind(this);
    this.handleAltChange = this.handleAltChange.bind(this);
  }

  editClick = () =>{
		this.setState({editing: true});
	}
	saveClick = () =>{
		this.setState({editing: false});
	}

  handleNameChange(event) {
    this.setState({filename: "images/" + event.target.value});
  }

  handleAltChange(event) {
    this.setState({alt: event.target.value});
  }

  renderNormal() {
    return(
      <div>
        <h2>{this.state.alt}</h2>
        <img src={this.state.filename} alt={this.state.alt} onClick={this.editClick}></img>
      </div>
    );
  };

  renderEdit() {
    return(
      <div>
        <p> File name: &nbsp;
          <select onChange={this.handleNameChange}>
            <option>Choose Image</option>
            <option>img1.jpg</option>
            <option>img2.jpg</option>
            <option>img3.jpg</option>
            <option>img4.jpg</option>
          </select>
        </p>
        <p> Alt: &nbsp;
          <input type="text" onChange={this.handleAltChange}/>
        </p>
        <button onClick={this.saveClick}>Save</button>
      </div>
    );
  };

  render() {
    if(this.state.editing){
			return(this.renderEdit());
		}else{
			return(this.renderNormal());
		}
  }
}

// If you want to start measuring performance in your app, pass a function
// to log results (for example: reportWebVitals(console.log))
// or send to an analytics endpoint. Learn more: https://bit.ly/CRA-vitals
reportWebVitals();
