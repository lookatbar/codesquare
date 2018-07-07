import React, { Component } from 'react';
import logo from '../images/logo.svg';
import '../stylesheets/App.css';
import { routeMap } from '../routes';

// @todo 获取用户信息

class App extends Component {
  componentDidMount(){
    
  }

  componentWillReceiveProps({route}){
    if(route !== this.props.route){
      console.log(route);
    }
  }


  render() {
    return (
      <div className="App">
        { this.props.cihldren }
      </div>
    );
  }
}

export default App;
