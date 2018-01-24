import React, { Component } from 'react';
import './../css/Login.css';

class Login extends Component {
	constructor(props){
		super(props);
		this.state = {
			lonerStatus : 'false',
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
			particapationType1 : detail1,
			particapationType2 : detail2,
			hidden : 'credentials',
			selectParticipationType : 'hidden',
			inputType : 'text'
		});
	}
	Submit(){
		console.log('submit')
	}
  render() {
	// console.log(this.state.loner_status);
	// console.log(this.state.team_status);
    return (
        <div className="login-wrap">
                <div className="row">
			<div className="col3 ">
				<div className= {this.state.selectParticipationType}>
					<button onClick={this.loner.bind(this)}  className = 'loner_type'>Loner Register</button>
					<button onClick={this.team.bind(this)}  className = 'team_type'>Team Register</button>
				</div>
				<div className = {this.state.hidden}>
					<input placeholder={this.state.particapationType1} value = {(e)=>{this.setState({credential1 :e.target.value})}} className='credential_1' type={this.state.inputType}/>
					<input placeholder={this.state.particapationType2} value = {(e)=>{this.setState({credential2 :e.target.value})}} className='credential_2' type="text"/>
					<button onSubmit = {this.Submit.bind(this)} className = 'team_type'>Submit</button>
				</div>
			</div>
			<div className="col7"> 
			
			</div>
		</div>
        </div>
    );
  }
}

export default Login;