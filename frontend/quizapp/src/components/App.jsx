import React, { Component } from 'react';
import Login from './Login.jsx';
import Quiz from './quiz.jsx';
import {  BrowserRouter, Route } from 'react-router-dom'

class App extends Component {
	constructor(props){
		super(props);
		this.state = {
			status : null,
			base_domain : `http://quizportal.cf/backend/`
		}
	}
	statusUpdate(obj){
		this.setState({
			status: obj
		})
	}
	render() {
		return (
			<BrowserRouter>
				<div>
					<Route path='/login' statusUpdate = {this.statusUpdate.bind(this)}  component={Login} baseUrl={this.state.base_domain} />
					<Route path='/dashboard' component={Quiz} baseUrl={this.state.base_domain} />
				</div>
			</BrowserRouter>
		);
	}
}

export default App;
