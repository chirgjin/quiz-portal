import React, { Component } from 'react';
import 'bootstrap/dist/css/bootstrap.css';
import './../css/Login.css';

class Login extends Component {
	constructor(props){
		super(props);
		this.state = {
			teamStatus : 'false',
			credential1 : '',
			credential2 : '',
			loginStatus : "false",	
			particapationType1 : "",
			particapationType2 : "",
			hidden : 'hidden',
			selectParticipationType : 'selectParticipationType',
			inputType : ''
		}
	}

	loner(){
		let detail1 = 'Enter Email';
		let detail2 = 'Enter Phone Number';
		console.log("loner");
		this.setState({
			particapationType1 : detail1,
			particapationType2 : detail2,
			hidden : 'credentials',
			selectParticipationType : 'hidden',
			inputType : 'email'
		});
		
	}
	team(){
		let detail1 = 'Enter Team Name';
		let detail2 = 'Enter Code';
		console.log("Team");
		this.setState({
			teamStatus : 'true',
			particapationType1 : detail1,
			particapationType2 : detail2,
			hidden : 'credentials',
			selectParticipationType : 'hidden',
			inputType : 'text'
		});
	}
	handelCredential1Change({target}){
		this.setState({
			credential1:target.value
		})
	}
	handelCredential2Change({target}){
		this.setState({
			credential2:target.value
		})
	}
	Submit(){
		let data;
		console.log('submit')
		console.log(`credential1 = ${this.state.credential1}`);
		console.log(`credential2 = ${this.state.credential2}`);
		if(this.state.teamStatus === 'false'){
			data = {
				isTeam : this.state.teamStatus,
				email : this.state.credential1,
				phone : this.state.credential2
			}
		}else{
			data = {
				isTeam : this.state.teamStatus,
				teamName : this.state.credential1,
				teamCode : this.state.credential2
			}
		}

		console.log(data.isTeam);
		// fetch('http://anidl.cf/quiz/login', {
		// 	method: 'GET',
		// 	headers: 
		// }).then(res => {
		// 	console.log(res);
		// 	return res;
		// }).catch(err => console.log(err));

	}
  render() {
	// console.log(this.state.loner_status);
	// console.log(this.state.team_status);
    return (
        <div className="login-wrap">
                <div className="row">
			<div className="col-3 ">
				<div className= {this.state.selectParticipationType}>
					<button onClick={this.loner.bind(this)}  className = 'loner_type'>Loner Register</button>
					<button onClick={this.team.bind(this)}  className = 'team_type'>Team Register</button>
				</div>
				<div className = {this.state.hidden}>
					<input placeholder={this.state.particapationType1} value={this.state.credential1} onChange={this.handelCredential1Change.bind(this)} className='credential_1' type={this.state.inputType}/>
					<input placeholder={this.state.particapationType2} value={this.state.credential2} onChange={this.handelCredential2Change.bind(this)} className='credential_2' type="text"/>
					<button onClick= {this.Submit.bind(this)} className = 'submit_form'>Submit</button>
				</div>
			</div>
			<div className="col-9 section-background"> 

			</div>
		</div>
        </div>
    );
  }
}

export default Login;